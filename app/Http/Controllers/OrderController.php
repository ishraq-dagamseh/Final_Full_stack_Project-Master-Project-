<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\MenuItem;
use App\Models\Restaurant;

class OrderController extends Controller
{


    public function index()
    {
        // If restaurant dashboard orders
        if(auth()->user()->role == 'restaurant') {
            $restaurant = Restaurant::where('user_id', auth()->id())->first();

            if (!$restaurant) {
                return redirect()->route('home')->with('error', 'No restaurant assigned.');
            }

            $orders = Order::where('restaurant_id', $restaurant->id)->get();

            return view('dashboard.orders', compact('orders'));
        }

        // For admin dashboard
        if(auth()->user()->role == 'admin') {
            $orders = Order::latest()->get();
            return view('admin.orders', compact('orders'));
        }

        abort(403, 'Unauthorized access.');
    }


    public function store(Request $request)
{
    $order = Order::create([
        'user_id' => auth()->id(),
        'restaurant_id' => $request->restaurant_id,
        'total' => MenuItem::find($request->menu_item_id)->price,
        'status' => 'pending',
    ]);

    $order->orderItems()->create([
        'menu_item_id' => $request->menu_item_id,
        'quantity' => 1,
        'price' => MenuItem::find($request->menu_item_id)->price,
    ]);

    return back()->with('success', 'Order placed successfully!');
}

    public function cancel($id)
    {
        $order = Order::where('menu_item_id', $id)
                      ->where('user_id', auth()->id())
                      ->first();

        if ($order) {
            $order->delete();
        }

        return back()->with('success', 'Order cancelled.');
    }
}
