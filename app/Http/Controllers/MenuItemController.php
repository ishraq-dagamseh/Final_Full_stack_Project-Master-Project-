<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MenuItem;

class MenuItemController extends Controller
{
    public function index()
    {
        $restaurant = auth()->user();
        $menuItems = MenuItem::where('restaurant_id', $restaurant->id)->get();
        return view('dashboard.menuitem', compact('menuItems'));
    }

    public function create()
    {
        return view('dashboard.menuitem-create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
        ]);

        MenuItem::create([
            'restaurant_id' => auth()->id(),
            'name' => $request->name,
            'price' => $request->price,
        ]);

        return redirect()->route('menu-items.index')->with('success', 'Menu item added!');
    }

    public function edit($id)
    {
        $menuItem = MenuItem::findOrFail($id);
        return view('dashboard.menuitem-edit', compact('menuItem'));
    }

    public function update(Request $request, $id)
    {
        $menuItem = MenuItem::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
        ]);

        $menuItem->update($request->only('name', 'price'));

        return redirect()->route('menu-items.index')->with('success', 'Menu item updated!');
    }

    public function destroy($id)
    {
        $menuItem = MenuItem::findOrFail($id);
        $menuItem->delete();

        return redirect()->route('menu-items.index')->with('success', 'Menu item deleted!');
    }
}
