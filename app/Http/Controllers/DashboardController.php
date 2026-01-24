<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\User;
use App\Models\Project;
use App\Models\Activity;
use App\Models\Keuangan;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;



class DashboardController extends Controller
{


    public function index()
    {
        /* ===============================
         |  DATA KOMUNITAS & DIVISI
         |===============================*/
        $communities = Unit::whereNull('parent_id')
            ->withCount(['children as divisions_count', 'users'])
            ->get();

        $totalCommunities = Unit::whereNull('parent_id')->count();
        $totalDivisions   = Unit::whereNotNull('parent_id')->count();

        /* ===============================
         |  USER
         |===============================*/
        $totalUsers = User::count();

        /* ===============================
         |  PROJECT
         |===============================*/
        $totalProjects = Project::count();

        /* ===============================
         |  ACTIVITY
         |===============================*/
        $totalActivities = Activity::count();

        $upcomingActivities = Activity::whereDate('start_date', '>=', now())
            ->orderBy('start_date')
            ->limit(5)
            ->get();

            /* ===============================
            |  RANGE WAKTU
            |===============================*/
            $startThisMonth = Carbon::now()->startOfMonth();
            $endThisMonth   = Carbon::now()->endOfMonth();

            $startLastMonth = Carbon::now()->subMonth()->startOfMonth();
            $endLastMonth   = Carbon::now()->subMonth()->endOfMonth();

            /* ===============================
            |  USER GROWTH
            |===============================*/
            $usersThisMonth = User::whereBetween('created_at', [$startThisMonth, $endThisMonth])->count();
            $usersLastMonth = User::whereBetween('created_at', [$startLastMonth, $endLastMonth])->count();

            $userGrowth = $usersLastMonth == 0
                ? ($usersThisMonth > 0 ? 100 : 0)
                : round((($usersThisMonth - $usersLastMonth) / $usersLastMonth) * 100, 1);

            /* ===============================
            |  DIVISION GROWTH
            |===============================*/
            $divisionsThisMonth = Unit::whereNotNull('parent_id')
                ->whereBetween('created_at', [$startThisMonth, $endThisMonth])
                ->count();

            $divisionsLastMonth = Unit::whereNotNull('parent_id')
                ->whereBetween('created_at', [$startLastMonth, $endLastMonth])
                ->count();

            $divisionGrowth = $divisionsLastMonth == 0
                ? ($divisionsThisMonth > 0 ? 100 : 0)
                : round((($divisionsThisMonth - $divisionsLastMonth) / $divisionsLastMonth) * 100, 1);

            /* ===============================
            |  PROJECT GROWTH
            |===============================*/
            $projectsThisMonth = Project::whereBetween('created_at', [$startThisMonth, $endThisMonth])->count();
            $projectsLastMonth = Project::whereBetween('created_at', [$startLastMonth, $endLastMonth])->count();

            $projectGrowth = $projectsLastMonth == 0
                ? ($projectsThisMonth > 0 ? 100 : 0)
                : round((($projectsThisMonth - $projectsLastMonth) / $projectsLastMonth) * 100, 1);


                /* ===============================
 |  PROJECT PROGRESS
 |===============================*/
$projectProgress = Project::withCount([
        'tasks',
        'tasks as done_tasks_count' => function ($query) {
            $query->where('status', 'done');
        }
    ])
    ->latest()
    ->take(5)
    ->get()
    ->map(function ($project) {
        $progress = $project->tasks_count > 0
            ? round(($project->done_tasks_count / $project->tasks_count) * 100)
            : 0;

        return [
            'id'        => $project->id,
            'name'      => $project->name,
            'progress'  => $progress,
        ];
    });

/* ===============================
 | USER DISTRIBUTION BY DIVISION
 |===============================*/
$divisions = Unit::whereNotNull('parent_id')
    ->withCount('users')
    ->get();

$totalUsers = $divisions->sum('users_count');

$colors = ['#3C50E0', '#6577F3', '#8FD0EF', '#F59E0B', '#22C55E', '#EF4444'];

$userByDivision = $divisions->map(function ($division, $index) use ($totalUsers, $colors) {
    $percent = $totalUsers > 0
        ? round(($division->users_count / $totalUsers) * 100, 1)
        : 0;

    return [
        'name'    => $division->name,
        'users'   => $division->users_count,
        'percent' => $percent,
        'color'   => $colors[$index % count($colors)],
    ];
});

        // --- FINANCIAL STATISTICS START ---
        $totalPemasukan = Keuangan::where('jenis', 1)->sum('nominal');
        $totalPengeluaran = Keuangan::where('jenis', 2)->sum('nominal');
        $saldo = $totalPemasukan - $totalPengeluaran;

        // Chart Data (Monthly for last 12 months)
        $chartData = $this->getFinancialChartData();
        // --- FINANCIAL STATISTICS END ---
        /* ===============================
         |  KIRIM KE VIEW
         |===============================*/
        return view('pages.dashboard.ecommerce', compact(
            'communities',
            'totalUsers',
            'totalCommunities',
            'totalDivisions',
            'totalProjects',
            'totalActivities',
            'upcomingActivities',
            'userGrowth',
            'divisionGrowth',
            'projectGrowth',
            'projectProgress',
            'userByDivision',
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
