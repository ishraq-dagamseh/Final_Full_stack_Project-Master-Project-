@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-gray-100">

    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-md">
        <div class="p-6 font-bold text-xl border-b">Admin Dashboard</div>
        <nav class="p-6 flex flex-col space-y-2">
            <a href="{{ route('dashboard.admin') }}" 
               class="block py-2 px-4 rounded hover:bg-gray-200">Dashboard</a>
            
            <!-- Logout -->
            <form action="{{ route('logout') }}" method="POST" class="mt-4">
                @csrf
                <button type="submit" 
                        class="w-full text-left py-2 px-4 rounded hover:bg-red-500 hover:text-white text-red-600">
                    Logout
                </button>
            </form>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-6">

        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <div class="card text-center bg-light shadow-sm bg-green">
                    <div class="card-body">
                        <h5 class="card-title">Total Users</h5>
                        <h3 class="card-text">{{ $TotalUsers }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card text-center bg-light shadow-sm bg-yellow">
                    <div class="card-body">
                        <h5 class="card-title">Total Restaurants</h5>
                        <h3 class="card-text">{{ $TotalRestaurants }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card text-center bg-light shadow-sm bg-blue">
                    <div class="card-body">
                        <h5 class="card-title">Total Orders</h5>
                        <h3 class="card-text">{{ $TotalOrders }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Latest Orders Table -->
        <div class="card shadow mb-4">
            <div class="card-header">
                <h5 class="mb-0">Latest Orders</h5>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Restaurant</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($latestOrders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->user->name ?? 'N/A' }}</td>
                            <td>{{ $order->restaurant->name ?? 'N/A' }}</td>
                            <td>${{ $order->total }}</td>
                            <td>{{ ucfirst($order->status) }}</td>
                            <td>{{ $order->created_at->format('Y-m-d') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">No orders found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Restaurants Table -->
        <div class="card shadow mb-4">
            <div class="card-header">
                <h5 class="mb-0">Restaurants</h5>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Description</th>
                            <th>Location</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($restaurants as $restaurant)
                        <tr>
                            <td>{{ $restaurant->id }}</td>
                            <td>{{ $restaurant->name }}</td>
                            <td>{{ $restaurant->phone }}</td>
                            <td>{{ $restaurant->description }}</td>
                            <td>{{ $restaurant->location }}</td>
                            <td>{{ $restaurant->created_at->format('Y-m-d') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">No restaurants found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Users Table -->
        <div class="card shadow mb-4">
            <div class="card-header">
                <h5 class="mb-0">Users</h5>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ ucfirst($user->role ?? 'User') }}</td>
                            <td>{{ $user->created_at->format('Y-m-d') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">No users found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </main>
</div>
@endsection
