<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\MenuItem;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::with([
            'items.children'
        ])->get();

        return view('menu.index', compact('menus'));
    }

    // public function index()
    // {
    //     $menuItems = MenuItem::with('children')->orderBy('order')->get();

    //     return view('menu.index', compact('menuItems'));
    // }


    public function store(Request $request)
    {
        Menu::create($request->validate(['title' => 'required']));
        return back()->with('success', 'Menu group created');
    }
}
