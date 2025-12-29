<?php
// Wallahi I'm tired :(

namespace App\Http\Controllers;

use App\Models\Keuangan;
use App\Models\KategoriKeuangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class KeuanganController extends Controller
{
    public function index(Request $request)
    {
        $query = Keuangan::with('kategori');

        // Filter Logic
        if ($request->filled('start_date')) {
            $query->whereDate('tanggal', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('tanggal', '<=', $request->end_date);
        }
        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }
        if ($request->filled('kategori_id')) {
            $query->where('kategori_keuangan_id', $request->kategori_id);
        }

        // Sorting: Transaksi terbaru di atas
        $query->orderBy('tanggal', 'asc')->orderBy('created_at', 'asc');

        $keuangans = $query->paginate(10)->withQueryString();
        $kategoris = KategoriKeuangan::all();
        

        // Get period type from request (default: harian) 
        $periodType = $request->get('period', 'harian'); // harian, mingguan, bulanan

        // Prepare chart data based on period type
        $chartData = $this->getChartData($periodType, $request);

        // Calculate Totals for Summary Cards
        $totalPemasukan = Keuangan::where('jenis', 1)->sum('nominal');
        $totalPengeluaran = Keuangan::where('jenis', 2)->sum('nominal');
        $saldo = $totalPemasukan - $totalPengeluaran;

        return view('keuangan.index', compact(
            'keuangans',
            'kategoris',
            'totalPemasukan',
            'totalPengeluaran',
            'saldo',
            'chartData',
            'periodType'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_keuangan_id' => 'required',
            'new_category_name' => 'required_if:kategori_keuangan_id,new',
            'uraian' => 'required',
            'jenis' => 'required|in:1,2',
            'nominal' => 'required|numeric',
            'tanggal' => 'required|date',
            'bukti_file.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $kategoriId = $request->kategori_keuangan_id;

        if ($kategoriId === 'new') {
            $newKategori = KategoriKeuangan::create([
                'nama_kategori' => $request->new_category_name,
                'jenis_transaksi' => $request->jenis == '1' ? 'masuk' : 'keluar'
            ]);
            $kategoriId = $newKategori->id;
        }

        $keuangan = Keuangan::create([
            'user_id' => Auth::id() ?? 1, 
            'kategori_keuangan_id' => $kategoriId,
            'uraian' => $request->uraian,
            'jenis' => $request->jenis,
            'nominal' => $request->nominal,
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan ?? ''
        ]);

        if ($request->hasFile('bukti_file')) {
            foreach ($request->file('bukti_file') as $file) {
                $path = $file->store('bukti-keuangan', 'public');
                $keuangan->buktis()->create(['file_path' => $path]);
            }
        }

        return redirect()->route('keuangan.index')->with('success', 'Transaksi berhasil dicatat');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jenis' => 'required|in:1,2',
            'kategori_keuangan_id' => 'required',
            'nominal' => 'required|numeric',
            'uraian' => 'required',
            'tanggal' => 'required|date',
        ]);

        $keuangan = Keuangan::findOrFail($id);

        $keuangan->update([
            'jenis' => $request->jenis,
            'kategori_keuangan_id' => $request->kategori_keuangan_id,
            'nominal' => $request->nominal,
            'uraian' => $request->uraian,
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan ?? $keuangan->keterangan
        ]);

        return redirect()->route('keuangan.index')->with('success', 'Data berhasil diperbarui');
    }

    public function destroy($id)
    {
        try {
            $keuangan = Keuangan::findOrFail($id);
            foreach($keuangan->buktis as $bukti){
                Storage::delete($bukti->file_path);
            }
            $keuangan->delete();
            return redirect()->route('keuangan.index')->with('success', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('keuangan.index')->with('error', 'Gagal menghapus data');
        }
    }

    private function getChartData($periodType, $request)
    {
        $baseQuery = Keuangan::query();

        // Apply date filters if exists
        if ($request->filled('start_date')) {
            $baseQuery->whereDate('tanggal', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $baseQuery->whereDate('tanggal', '<=', $request->end_date);
        }

        switch ($periodType) {
            case 'bulanan':
                return $this->getMonthlyData($baseQuery);
            case 'mingguan':
                return $this->getWeeklyData($baseQuery);
            case 'harian':
            default:
                return $this->getDailyData($baseQuery, $request);
        }
    }

    private function getDailyData($baseQuery, $request)
    {
        $chartQuery = clone $baseQuery;
        $chartQuery->selectRaw('DATE(tanggal) as period, jenis, SUM(nominal) as total')
            ->groupBy('period', 'jenis')
            ->orderBy('period', 'asc');

        $rawChartData = $chartQuery->get();

        // Generate date range
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $startDate = Carbon::parse($request->start_date);
            $endDate = Carbon::parse($request->end_date);
        } else {
            $startDate = Carbon::now()->subDays(30);
            $endDate = Carbon::now();
        }
        
        $period = \Carbon\CarbonPeriod::create($startDate, $endDate);
        $dates = [];
        $pemasukanData = [];
        $pengeluaranData = [];

        foreach ($period as $date) {
            $formattedDate = $date->format('Y-m-d');
            $dates[] = $date->format('d M');
            
            $pemasukan = $rawChartData->where('period', $formattedDate)->where('jenis', 1)->first()->total ?? 0;
            $pengeluaran = $rawChartData->where('period', $formattedDate)->where('jenis', 2)->first()->total ?? 0;
            
            $pemasukanData[] = (float) $pemasukan;
            $pengeluaranData[] = (float) $pengeluaran;
        }

        return [
            'dates' => $dates,
            'pemasukan' => $pemasukanData,
            'pengeluaran' => $pengeluaranData
        ];
    }

    private function getWeeklyData($baseQuery)
    {
        $chartQuery = clone $baseQuery;
        $chartQuery->selectRaw('YEARWEEK(tanggal, 1) as period, jenis, SUM(nominal) as total')
            ->groupBy('period', 'jenis')
            ->orderBy('period', 'asc');

        $rawChartData = $chartQuery->get();

        // Get last 12 weeks
        $startDate = Carbon::now()->subWeeks(11)->startOfWeek();
        $endDate = Carbon::now()->endOfWeek();
        
        $dates = [];
        $pemasukanData = [];
        $pengeluaranData = [];

        $current = $startDate->copy();
        while ($current <= $endDate) {
            $weekNumber = $current->format('oW'); // ISO week format
            $dates[] = 'Minggu ' . $current->format('d M');
            
            $pemasukan = $rawChartData->where('period', $weekNumber)->where('jenis', 1)->first()->total ?? 0;
            $pengeluaran = $rawChartData->where('period', $weekNumber)->where('jenis', 2)->first()->total ?? 0;
            
            $pemasukanData[] = (float) $pemasukan;
            $pengeluaranData[] = (float) $pengeluaran;
            
            $current->addWeek();
        }

        return [
            'dates' => $dates,
            'pemasukan' => $pemasukanData,
            'pengeluaran' => $pengeluaranData
        ];
    }

    private function getMonthlyData($baseQuery)
    {
        $chartQuery = clone $baseQuery;
        $chartQuery->selectRaw('DATE_FORMAT(tanggal, "%Y-%m") as period, jenis, SUM(nominal) as total')
            ->groupBy('period', 'jenis')
            ->orderBy('period', 'asc');

        $rawChartData = $chartQuery->get();

        // Get last 12 months
        $startDate = Carbon::now()->subMonths(11)->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();
        
        $dates = [];
        $pemasukanData = [];
        $pengeluaranData = [];

        $current = $startDate->copy();
        while ($current <= $endDate) {
            $monthKey = $current->format('Y-m');
            $dates[] = $current->translatedFormat('M Y'); // e.g., "Des 2024"
            
            $pemasukan = $rawChartData->where('period', $monthKey)->where('jenis', 1)->first()->total ?? 0;
            $pengeluaran = $rawChartData->where('period', $monthKey)->where('jenis', 2)->first()->total ?? 0;
            
            $pemasukanData[] = (float) $pemasukan;
            $pengeluaranData[] = (float) $pengeluaran;
            
            $current->addMonth();
        }

        return [
            'dates' => $dates,
            'pemasukan' => $pemasukanData,
            'pengeluaran' => $pengeluaranData
        ];
    }
}