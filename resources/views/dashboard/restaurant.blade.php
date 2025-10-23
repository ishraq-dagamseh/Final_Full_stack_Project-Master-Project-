@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-gray-100">

    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-md">
        <div class="p-6 font-bold text-xl border-b">Restaurant Dashboard</div>
        <nav class="p-6 space-y-2">
            <a href="{{ route('dashboard.restaurant') }}" class="block py-2 px-4 rounded hover:bg-gray-200">Dashboard</a>
            <a href="{{ route('menu-items.index') }}" class="block py-2 px-4 rounded hover:bg-gray-200">Menu Items</a>
            <a href="{{ route('restaurant.orders') }}" class="block py-2 px-4 rounded hover:bg-gray-200">Orders</a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full text-left py-2 px-4 rounded hover:bg-red-500 hover:text-white text-red-600">
                    Logout
                </button>
            </form>
        </nav>
    </aside>

    <!-- Main content -->
    <div class="flex-1 p-6">

        <h1 class="text-3xl font-bold mb-6">Welcome, {{ auth()->user()->name }}</h1>

        <!-- Stats Cards -->
        <div class="grid grid-cols-4 gap-6 mb-6">
            <div class="bg-white shadow rounded p-4">
                <h3 class="text-gray-500">Total Orders</h3>
                <p class="text-2xl font-bold">{{ $orders->count() }}</p>
            </div>
            <div class="bg-white shadow rounded p-4">
                <h3 class="text-gray-500">Pending Orders</h3>
                <p class="text-2xl font-bold">{{ $orders->where('status','pending')->count() }}</p>
            </div>
            <div class="bg-white shadow rounded p-4">
                <h3 class="text-gray-500">Completed Orders</h3>
                <p class="text-2xl font-bold">{{ $orders->where('status','completed')->count() }}</p>
            </div>
            <div class="bg-white shadow rounded p-4">
                <h3 class="text-gray-500">Revenue</h3>
                <p class="text-2xl font-bold">${{ $totalRevenue }}</p>
            </div>
        </div>

        <!-- Recent Orders Table -->
        <div class="bg-white shadow rounded p-6 mb-6">
            <h2 class="text-xl font-bold mb-4">Recent Orders</h2>
            <table class="min-w-full table-auto">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2">Order ID</th>
                        <th class="px-4 py-2">Customer</th>
                        <th class="px-4 py-2">Items</th>
                        <th class="px-4 py-2">Total</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr class="border-b">
                        <td class="px-4 py-2">{{ $order->id }}</td>
                        <td class="px-4 py-2">{{ $order->user->name }}</td>
                        <td class="px-4 py-2">
                            @foreach($order->orderItems as $item)
                                {{ $item->menuItem->name }} (x{{ $item->quantity }})<br>
                            @endforeach
                        </td>
                        <td class="px-4 py-2">${{ $order->total }}</td>
                        <td class="px-4 py-2 capitalize">{{ $order->status }}</td>
                        <td class="px-4 py-2">
                            <form action="{{ route('restaurant.orders.updateStatus', $order) }}" method="POST" class="flex gap-2">
                                @csrf
                                <select name="status" class="border rounded px-2 py-1">
                                    <option value="pending" @if($order->status=='pending') selected @endif>Pending</option>
                                    <option value="accepted" @if($order->status=='accepted') selected @endif>Accepted</option>
                                    <option value="rejected" @if($order->status=='rejected') selected @endif>Rejected</option>
                                    <option value="completed" @if($order->status=='completed') selected @endif>Completed</option>
                                </select>
                                <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">Update</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Menu Items Table (with Order button for users) -->
        <div class="bg-white shadow rounded p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold">Menu Items</h2>
                <a href="{{ route('menu-items.create') }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Add New Item</a>
            </div>
            <table class="min-w-full table-auto">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2">Name</th>
                        <th class="px-4 py-2">Category</th>
                        <th class="px-4 py-2">Price</th>
                        <th class="px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($menuItems as $item)
                    <tr class="border-b">
                        <td class="px-4 py-2">{{ $item->name }}</td>
                        <td class="px-4 py-2">{{ $item->category->name ?? '-' }}</td>
                        <td class="px-4 py-2">${{ $item->price }}</td>
                        <td class="px-4 py-2 flex gap-2">
                            <a href="{{ route('menu-items.edit', $item) }}" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">Edit</a>
                            <form action="{{ route('menu-items.destroy', $item) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Delete</button>
                            </form>

                            <!-- ORDER BUTTON FOR USER -->
                            <form action="{{ route('orders.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="restaurant_id" value="{{ $item->restaurant_id }}">
                                <input type="hidden" name="menu_item_id" value="{{ $item->id }}">
                                <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">
                                    Order
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection
