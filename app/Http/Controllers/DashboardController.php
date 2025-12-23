<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Unit;

class DashboardController extends Controller
{
  public function index()
    {
        $communities = Unit::whereNull('parent_id')
                           ->withCount(['children', 'users'])
                           ->get();

    
        return view('pages.dashboard.ecommerce', compact('communities'));
    }
}
