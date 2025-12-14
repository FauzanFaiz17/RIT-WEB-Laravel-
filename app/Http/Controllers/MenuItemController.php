<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\MenuItem;

class MenuItemController extends Controller
{
    public function index()
    {
        $menus = Menu::with('items.children')->get();
        return view('menu.items.index', compact('menus'));
    }

    public function create()
    {
        $menus = Menu::all();
        $parents = MenuItem::whereNull('parent_id')->get();

        return view('menu.items.create', compact('menus', 'parents'));
    }

    public function store(Request $request)
    {
        MenuItem::create($request->validate([
            'menu_id' => 'required',
            'parent_id' => 'nullable',
            'name' => 'required',
            'icon' => 'nullable',
            'path' => 'nullable',
            'order' => 'required|integer',
            'is_active' => 'boolean'
        ]));

        return redirect()->route('menu-items.index');
    }

    public function edit(MenuItem $menuItem)
    {
        $menus = Menu::all();
        $parents = MenuItem::whereNull('parent_id')
            ->where('id', '!=', $menuItem->id)
            ->get();

        return view('menu.items.edit', compact('menuItem', 'menus', 'parents'));
    }

    public function update(Request $request, MenuItem $menuItem)
    {
        $menuItem->update($request->all());
        return redirect()->route('menu-items.index');
    }

    public function destroy(MenuItem $menuItem)
    {
        $menuItem->delete();
        return back();
    }

    public function reorder(Request $request)
    {
        foreach ($request->items as $index => $item) {
            MenuItem::where('id', $item['id'])->update([
                'order' => $index + 1,
                'parent_id' => $item['parent_id']
            ]);
        }

        return response()->json(['success' => true]);
    }
}
