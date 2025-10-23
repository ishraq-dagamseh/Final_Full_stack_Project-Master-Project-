@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-gray-100">

    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-md">
        <div class="p-6 font-bold text-xl border-b">Restaurant Dashboard</div>
        <nav class="p-6 space-y-2">
            <a href="{{ route('dashboard.restaurant') }}" class="block py-2 px-4 rounded hover:bg-gray-200 {{ request()->routeIs('dashboard.restaurant') ? 'bg-gray-200 font-semibold' : '' }}">Dashboard</a>
            <a href="{{ route('menu-items.index') }}" class="block py-2 px-4 rounded hover:bg-gray-200 {{ request()->routeIs('menu-items.*') ? 'bg-gray-200 font-semibold' : '' }}">Menu Items</a>
            <a href="{{ route('restaurant.orders') }}" class="block py-2 px-4 rounded hover:bg-gray-200 {{ request()->routeIs('restaurant.orders') ? 'bg-gray-200 font-semibold' : '' }}">Orders</a>
            <!-- Logout -->
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="w-full text-left py-2 px-4 rounded hover:bg-red-500 hover:text-white text-red-600">
            Logout
        </button>
    </form>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-6">
        <h1 class="text-3xl font-bold mb-6">Orders</h1>

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto bg-white rounded shadow">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Order ID</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Customer</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Total Price</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Status</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Change Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($orders as $order)
                        <tr>
                            <td class="px-4 py-2">{{ $order->id }}</td>
                            <td class="px-4 py-2">{{ $order->user->name ?? 'N/A' }}</td>
                            <td class="px-4 py-2">${{ $order->total_price }}</td>
                            <td class="px-4 py-2 capitalize">{{ $order->status }}</td>
                            <td class="px-4 py-2">
                                <div class="flex space-x-2">
                                    @foreach(['pending', 'preparing', 'completed', 'cancelled'] as $status)
    <form action="{{ route('restaurant.orders.updateStatus', $order->id) }}" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" name="status" value="{{ $status }}">
        <button type="submit" class="px-2 py-1 text-sm rounded bg-blue-500 text-white">
            {{ ucfirst($status) }}
        </button>
    </form>
@endforeach

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-4 text-center text-gray-500">No orders found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>
</div>
@endsection
