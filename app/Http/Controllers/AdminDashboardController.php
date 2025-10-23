<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $latestOrders = Order::with(['user', 'restaurant'])
            ->latest()
            ->take(5)
            ->get();

        $TotalUsers = User::count();
        $TotalRestaurants = Restaurant::count();
        $TotalOrders = Order::count();

        $restaurants = Restaurant::latest()->take(10)->get();
        $users = User::latest()->take(10)->get();

        return view('dashboard.admin', compact(
            'latestOrders',
            'TotalUsers',
            'TotalRestaurants',
            'TotalOrders',
            'restaurants',
            'users'
        ));
    }
}
