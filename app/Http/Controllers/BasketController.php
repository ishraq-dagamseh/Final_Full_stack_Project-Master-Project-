<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BasketController extends Controller
{
    public function add(Request $request)
    {
        $count = session('basket.count', 0) + 1;
        $total = session('basket.total', 0) + $request->price;

        session(['basket.count' => $count, 'basket.total' => $total]);

        return back()->with('success', 'Item added to basket!');
    }

    public function remove(Request $request)
    {
        $count = max(0, session('basket.count', 0) - 1);
        $total = max(0, session('basket.total', 0) - $request->price);

        session(['basket.count' => $count, 'basket.total' => $total]);

        return back()->with('success', 'Item removed from basket!');
    }
}
