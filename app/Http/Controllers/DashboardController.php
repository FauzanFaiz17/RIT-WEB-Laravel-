<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Unit;     // Untuk Divisi
use App\Models\User;     // Untuk Total User
use App\Models\Activity; // Untuk Acara/Kegiatan

class DashboardController extends Controller
{
  public function index()
  {
    // Data untuk tabel Ringkasan Komunitas (tetap ada)
    $communities = Unit::whereNull('parent_id')
      ->withCount(['children', 'users'])
      ->get();

    $upcomingActivities = Activity::where('start_date', '>=', now()->startOfDay())
      ->orderBy('start_date', 'asc')
      ->take(5)
      ->get();


    // Data untuk 3 Kartu Metrik di baris pertama
    $totalUser = User::count();
    $totalActivity = Activity::count();

    // Menghitung Unit Utama (Komunitas)
    $totalCommunities = Unit::whereNull('parent_id')->count();

    // Menghitung Sub-Unit (Divisi/Departemen)
    $totalDivisions = Unit::whereNotNull('parent_id')->count();


    return view('pages.dashboard.ecommerce', compact(
      'communities',
      'totalUser',
      'totalDivisions',
      'totalActivity',
      'totalCommunities',
      'upcomingActivities'

    ));
  }
}
