<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activity;
use App\Models\Unit;
use App\Models\UnitUser;
use Illuminate\Support\Facades\Auth;

class ActivityController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | 1. NAVIGATION & MAIN VIEWS
    |--------------------------------------------------------------------------
    | Fungsi untuk mengatur tampilan utama kalender dan navigasi awal.
    */

    // Menangani akses dari Sidebar (tanpa ID di URL)
    public function indexGeneral()
    {
        $unitUser = UnitUser::where('user_id', Auth::id())->first();

        if (!$unitUser) {
            return redirect()->route('dashboard')->with('error', 'Anda belum terdaftar di unit manapun.');
        }

        return $this->index($unitUser->unit_id);
    }

    // Menampilkan Kalender Aktivitas Spesifik Unit
    public function index($unit_id)
    {
        $unit = Unit::findOrFail($unit_id);
        $activities = Activity::where('unit_id', $unit_id)->get();

        // Transformasi data untuk FullCalendar
        $events = $activities->map(function ($activity) {
            return [
                'id'    => $activity->id,
                'title' => $activity->title,
                'start' => \Carbon\Carbon::parse($activity->start_date)->toDateString(),
                'end'   => $activity->end_date
                    ? \Carbon\Carbon::parse($activity->end_date)->addDay()->toDateString()
                    : null,
                'allDay' => true,
                'color' => $activity->type === 'kegiatan' ? '#3C50E0' : '#FFA70B',
                'extendedProps' => [
                    'location'    => $activity->location,
                    'description' => $activity->description,
                    'type'        => $activity->type,
                    'status'      => $activity->status,
                ]
            ];
        });

        // Cek Jabatan Ketua
        $isKetua = UnitUser::where('user_id', Auth::id())
            ->where('unit_id', $unit_id)
            ->whereHas('role', function ($query) {
                $query->where('name', 'LIKE', '%Ketua%')
                    ->where('name', 'NOT LIKE', '%Wakil%');
            })->exists();

        return view('pages.calender', compact('unit', 'events', 'isKetua'));
    }

    // Halaman List Semua Unit
    public function allActivities()
    {
        return view('activities.all_units', [
            'units' => Unit::all()
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | 2. LIST VIEWS & FILTERING
    |--------------------------------------------------------------------------
    | Fungsi untuk menampilkan data dalam bentuk tabel/list dengan fitur filter status.
    */

    // Halaman List KEGIATAN RUTIN
    public function indexKegiatan(Request $request)
    {
        $unitUser = UnitUser::where('user_id', Auth::id())->first();
        $unitId = $unitUser ? $unitUser->unit_id : null;

        $query = Activity::where('type', 'kegiatan');

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $activities = $query->orderBy('start_date', 'desc')->paginate(10);
        $activities->appends($request->all());

        return view('activities.index', [
            'activities' => $activities,
            'pageTitle'  => 'Daftar Kegiatan Rutin',
            'pageType'   => 'kegiatan',
            'unitId'     => $unitId
        ]);
    }

    // Halaman List ACARA BESAR (EVENT)
    public function indexAcara(Request $request)
    {
        $unitUser = UnitUser::where('user_id', Auth::id())->first();
        $unitId = $unitUser ? $unitUser->unit_id : null;

        $query = Activity::where('type', 'acara');

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $activities = $query->orderBy('start_date', 'desc')->paginate(10);
        $activities->appends($request->all());

        return view('activities.index', [
            'activities' => $activities,
            'pageTitle'  => 'Daftar Acara Besar (Event)',
            'pageType'   => 'acara',
            'unitId'     => $unitId
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | 3. DATA PROCESSING (CRUD)
    |--------------------------------------------------------------------------
    | Fungsi untuk mengolah penyimpanan, pembaruan, dan penghapusan data.
    */

    // Simpan Data Baru
    public function store(Request $request, $unit_id)
    {
        $this->authorizeKetua($unit_id);

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'type'        => 'required|in:kegiatan,acara',
            'status'      => 'required|in:pending,progress,completed',
            'start_date'  => 'required|date',
            'end_date'    => 'nullable|date|after_or_equal:start_date',
            'location'    => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        Activity::create(array_merge($validated, ['unit_id' => $unit_id]));

        return redirect()->back()->with('success', 'Agenda berhasil disimpan!');
    }

    // Update Data (Form)
    public function update(Request $request, $id)
    {
        $activity = Activity::findOrFail($id);
        $this->authorizeKetua($activity->unit_id);

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'status'      => 'required|in:pending,progress,completed',
            'type'        => 'required|in:kegiatan,acara',
            'start_date'  => 'required|date',
            'end_date'    => 'nullable|date|after_or_equal:start_date',
            'location'    => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $activity->update($validated);

        return redirect()->back()->with('success', 'Data berhasil diperbarui!');
    }

    // Hapus Data
    public function destroy($id)
    {
        $activity = Activity::findOrFail($id);
        $this->authorizeKetua($activity->unit_id);
        $activity->delete();

        if (request()->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->back()->with('success', 'Agenda berhasil dihapus!');
    }


    /*
    |--------------------------------------------------------------------------
    | 4. CALENDAR SPECIFIC ACTIONS
    |--------------------------------------------------------------------------
    | Fungsi khusus untuk interaksi langsung pada FullCalendar (Drag & Drop).
    */

    public function dragUpdate(Request $request, $id)
    {
        $activity = Activity::findOrFail($id);
        $this->authorizeKetua($activity->unit_id);

        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date'   => 'nullable|date|after_or_equal:start_date',
        ]);

        $activity->update([
            'start_date' => $validated['start_date'],
            'end_date'   => $validated['end_date'] ?? null,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Updated'
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | 5. INTERNAL HELPER METHODS
    |--------------------------------------------------------------------------
    | Fungsi pembantu (private) untuk mendukung logika otorisasi dan keamanan.
    */

    private function authorizeKetua($unit_id)
    {
        $check = UnitUser::where('user_id', Auth::id())
            ->where('unit_id', $unit_id)
            ->whereHas('role', function ($query) {
                $query->where('name', 'LIKE', '%Ketua%')
                    ->where('name', 'NOT LIKE', '%Wakil%');
            })->exists();

        if (!$check) {
            abort(403, 'Hanya Ketua yang dapat mengelola agenda.');
        }
    }
}