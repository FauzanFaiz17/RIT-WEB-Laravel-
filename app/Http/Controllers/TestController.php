<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activity;


class TestController extends Controller
{
    public function test(){
          $upcomingActivities = Activity::where('start_date', '>=', now()->startOfDay())
      ->orderBy('start_date', 'asc')
      ->take(5)
      ->get();
      
        return view('test', [
        'totalUsers'       => 1280,
        'userGrowth'       => 12.5,

        'totalDivisions'   => 8,
        'divisionGrowth'   => 0,     // stagnan juga aman

        'totalProjects'   => 42,
        'projectGrowth'   => -3.2,
        'upcomingActivities'
    ]);
    }
}
