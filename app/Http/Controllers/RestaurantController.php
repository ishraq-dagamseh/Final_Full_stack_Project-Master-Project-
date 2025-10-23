<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\MenuItem;
use App\Models\Restaurant;


class RestaurantController extends Controller
{
    public function index()
{
    $restaurant = Restaurant::where('user_id', auth()->id())->first();

$orders = \App\Models\Order::where('restaurant_id', $restaurant->id)->get();
$menuItems = $restaurant->menuItems()->latest()->get();  // ensure fresh data
$totalRevenue = $orders->where('status', 'completed')->sum('total');

return view('dashboard.restaurant', compact('orders', 'menuItems', 'totalRevenue'));
}

public function orders()
{
    $restaurant = auth()->user();

    // Get all orders for this restaurant
    $orders = Order::where('restaurant_id', $restaurant->id)
                   ->latest()
                   ->get();

    // Count of completed orders
    $completedOrdersCount = $orders->where('status', 'completed')->count();

    // Total revenue from completed orders
    $totalRevenue = $orders->where('status', 'completed')->sum('total_price');

    return view('dashboard.orders', compact('orders', 'completedOrdersCount', 'totalRevenue'));
}


}
