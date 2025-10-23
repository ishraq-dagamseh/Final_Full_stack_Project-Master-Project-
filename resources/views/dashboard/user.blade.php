@extends('layouts.app')

@section('content')

    <!-- Background Image -->
    <img src="{{ asset('background.jpg') }}" 
         alt="Background"
         class="absolute inset-0 w-full h-full object-cover z-0">

    <!-- Dark overlay -->
    <div class="absolute inset-0 bg-black/40 z-10"></div>

    <!-- Top Controls -->
    <div class="absolute top-4 right-4 z-20 flex items-center space-x-4">
        <!-- Welcome Message -->
        <div class="bg-white/90 backdrop-blur-md px-6 py-4 rounded-xl shadow-md">
            <h1 class="text-xl  text-gray-800">
                Welcome {{ auth()->user()->name }} to Global Restaurant APP
            </h1>
        </div>

        <!-- Basket Summary -->
        <div class="bg-white/90 backdrop-blur-md px-5 py-3 rounded-xl shadow-md">
            @php
                $basketCount = session('basket.count', 0);
                $basketTotal = session('basket.total', 0);
            @endphp

            <div class="flex flex-col text-gray-800">
                <p class="font-bold text-lg"> Basket</p>
                <p class="text-sm">Items: <span class="font-semibold">{{ $basketCount }}</span></p>
                <p class="text-sm">Total: <span class="font-semibold text-blue-700">{{ number_format($basketTotal, 2) }} AED</span></p>
            </div>
        </div>
        

        <!-- Logout Button -->
        @auth
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
                class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                Logout
            </button>
        </form>
        @endauth
    </div>

    <!-- Main Content -->
    <div class="relative z-20 container mx-auto py-12 px-6">
        <h1 class="text-4xl font-bold text-white text-center mb-12">
            Explore Restaurants & Their Menus
        </h1>

        <!-- Restaurants Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($restaurants as $restaurant)
                <div class="bg-white/95 backdrop-blur-md shadow-lg rounded-2xl p-6 hover:scale-105 transition-transform duration-300">
                    <h2 class="text-2xl font-bold text-gray-800 mb-3">{{ $restaurant->name }}</h2>
                    <p class="text-gray-600 mb-4">{{ $restaurant->description ?? 'No description available.' }}</p>

                    <!-- Menu Items -->
                    @if($restaurant->menuItems->count() > 0)
                        <div class="border-t pt-4">
                            <h3 class="text-lg font-semibold mb-2 text-gray-700">Menu Items</h3>
                            <ul class="space-y-3">
                                @foreach($restaurant->menuItems as $item)
                                    <li class="border rounded-lg p-4 bg-gray-50 flex justify-between items-center">
                                        <div class="text-left flex-1">
                                            <p class="font-semibold text-gray-800">{{ $item->name }}</p>
                                            <p class="text-sm text-gray-600">{{ $item->description ?? 'No description.' }}</p>
                                            <p class="text-blue-600 font-bold mt-1">{{ $item->price }} AED</p>
                                        </div>

                                        <!-- Actions -->
                                        <div class="flex flex-col space-y-2 ml-4">
                                            <!-- Add to Basket -->
                                            <form action="{{ route('basket.add') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="item_id" value="{{ $item->id }}">
                                                <input type="hidden" name="price" value="{{ $item->price }}">
                                                <button type="submit"
                                                    class="px-3 py-2 bg-green-600 text-white rounded-lg text-sm hover:bg-green-700 transition">
                                                    Add to Basket
                                                </button>
                                            </form>

                                            <!-- Remove from Basket -->
                                            <form action="{{ route('basket.remove') }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="item_id" value="{{ $item->id }}">
                                                <input type="hidden" name="price" value="{{ $item->price }}">
                                                <button type="submit"
                                                    class="px-3 py-2 bg-red-600 text-white rounded-lg text-sm hover:bg-red-700 transition">
                                                    Remove
                                                </button>
                                            </form>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @else
                        <p class="italic text-gray-500">No menu items available.</p>
                    @endif
                </div>
            @empty
                <div class="col-span-full text-center text-white text-lg">
                    No restaurants available at the moment.
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
