<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Unit;
use App\Models\User;
use App\Models\Keuangan;
use Carbon\Carbon;
// use App\Models\Activity; // <--- JANGAN LUPA KOMEN INI

class DashboardController extends Controller
{
    public function index()
    {
        $communities = Unit::whereNull('parent_id')
            ->withCount(['children', 'users'])
            ->get();

        // --- BAGIAN INI YANG BIKIN ERROR, GANTI JADI INI: ---
        $upcomingActivities = []; // <--- KASIH ARRAY KOSONG BIAR GAK ERROR
        // $upcomingActivities = Activity::where('start_date', '>=', now()->startOfDay())
        //     ->orderBy('start_date', 'asc')
        //     ->take(5)
        //     ->get();

        $totalUser = User::count();

        // --- INI JUGA GANTI NOL ---
        $totalActivity = 0; 
        // $totalActivity = Activity::count();

        $totalCommunities = Unit::whereNull('parent_id')->count();
        $totalDivisions = Unit::whereNotNull('parent_id')->count();

        // --- FINANCIAL STATISTICS START ---
        $totalPemasukan = Keuangan::where('jenis', 1)->sum('nominal');
        $totalPengeluaran = Keuangan::where('jenis', 2)->sum('nominal');
        $saldo = $totalPemasukan - $totalPengeluaran;

        // Chart Data (Monthly for last 12 months)
        $chartData = $this->getFinancialChartData();
        // --- FINANCIAL STATISTICS END ---

        return view('pages.dashboard.ecommerce', compact(
            'communities',
            'totalUser',
            'totalDivisions',
            'totalActivity',
            'totalCommunities',
            'upcomingActivities',
            'totalPemasukan',
            'totalPengeluaran',
            'saldo',
            'chartData'
        ));
    }

    private function getFinancialChartData()
    {
        // Monthly data for the last 12 months
        $startDate = Carbon::now()->subMonths(11)->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();
        
        $query = Keuangan::query()
            ->selectRaw('DATE_FORMAT(tanggal, "%Y-%m") as period, jenis, SUM(nominal) as total')
            ->whereDate('tanggal', '>=', $startDate)
            ->whereDate('tanggal', '<=', $endDate)
            ->groupBy('period', 'jenis')
            ->orderBy('period', 'asc')
            ->get();

        $dates = [];
        $pemasukanData = [];
        $pengeluaranData = [];

        $current = $startDate->copy();
        while ($current <= $endDate) {
            $monthKey = $current->format('Y-m');
            $dates[] = $current->translatedFormat('M Y'); // e.g., "Des 2024"
            
            $pemasukan = $query->where('period', $monthKey)->where('jenis', 1)->first()->total ?? 0;
            $pengeluaran = $query->where('period', $monthKey)->where('jenis', 2)->first()->total ?? 0;
            
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