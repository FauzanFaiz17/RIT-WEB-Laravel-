<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activity;
use App\Models\Unit;
use App\Models\UnitUser;
use Illuminate\Support\Facades\Auth;

class ActivityController extends Controller
{
    /**
     * FUNGSI BARU: Menangani akses dari Sidebar (tanpa ID di URL)
     * Ini yang sebelumnya saya sebut indexGeneral
     */
    public function indexGeneral()
    {
        // Mencari unit pertama di mana user ini bergabung
        $unitUser = UnitUser::where('user_id', Auth::id())->first();

        if (!$unitUser) {
            return redirect()->route('dashboard')->with('error', 'Anda belum terdaftar di unit manapun.');
        }

        // Jika ketemu unitnya, panggil fungsi index di bawah dengan ID unit tersebut
        return $this->index($unitUser->unit_id);
    }

    /**
     * Menampilkan Kalender Aktivitas Spesifik Unit
     */
    public function index($unit_id)
    {
        $unit = Unit::findOrFail($unit_id);
        $activities = Activity::where('unit_id', $unit_id)->get();

        // Transformasi data untuk FullCalendar
        $events = $activities->map(function ($activity) {
            return [
                'id'    => $activity->id,
                'title' => $activity->title,

                // Pakai tanggal saja agar jadi allDay range
                'start' => \Carbon\Carbon::parse($activity->start_date)->toDateString(),

                // end +1 hari karena FullCalendar exclusive
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

        // PERBAIKAN: Mengarah ke folder pages sesuai gambar file manager Anda
        return view('pages.calender', compact('unit', 'events', 'isKetua'));
    }

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

    public function allActivities()
    {
        return view('activities.all_units', [
            'units' => Unit::all()
        ]);
    }

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


    // 2. Method untuk Halaman List KEGIATAN
    // Update method indexKegiatan
    public function indexKegiatan(Request $request) // <--- Tambahkan Request $request
    {
        // 1. Cari Unit ID user
        $unitUser = UnitUser::where('user_id', Auth::id())->first();
        $unitId = $unitUser ? $unitUser->unit_id : null;

        // 2. Mulai Query Dasar
        $query = Activity::where('type', 'kegiatan');

        // 3. Logika Filter (Jika ada status yang dipilih)
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // 4. Eksekusi Query dengan Pagination
        $activities = $query->orderBy('start_date', 'desc')->paginate(10);

        // Penting: Tambahkan ini agar filter tidak hilang saat pindah halaman (Pagination)
        $activities->appends($request->all());

        return view('activities.index', [
            'activities' => $activities,
            'pageTitle'  => 'Daftar Kegiatan Rutin',
            'pageType'   => 'kegiatan',
            'unitId'     => $unitId
        ]);
    }

    // Update method indexAcara
    public function indexAcara(Request $request) // <--- Tambahkan Request $request
    {
        $unitUser = UnitUser::where('user_id', Auth::id())->first();
        $unitId = $unitUser ? $unitUser->unit_id : null;

        $query = Activity::where('type', 'acara');

        // Logika Filter
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $activities = $query->orderBy('start_date', 'desc')->paginate(10);
        $activities->appends($request->all()); // Fix pagination link

        return view('activities.index', [
            'activities' => $activities,
            'pageTitle'  => 'Daftar Acara Besar (Event)',
            'pageType'   => 'acara',
            'unitId'     => $unitId
        ]);
    }


    public function update(Request $request, $id)
    {
        // 1. Cari data berdasarkan ID
        $activity = Activity::findOrFail($id);

        // 2. Cek apakah user adalah Ketua di unit tersebut
        $this->authorizeKetua($activity->unit_id);

        // 3. Validasi Input (Status wajib ada karena fitur utama edit adalah ganti status)
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'status'      => 'required|in:pending,progress,completed',
            'type'        => 'required|in:kegiatan,acara',
            'start_date'  => 'required|date',
            'end_date'    => 'nullable|date|after_or_equal:start_date',
            'location'    => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        // 4. Simpan Perubahan
        $activity->update($validated);

        // 5. Kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Data berhasil diperbarui!');
    }

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
}
