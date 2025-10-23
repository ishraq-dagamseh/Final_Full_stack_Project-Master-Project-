<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome to Global Restaurant App</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased">

<div class="flex-1 flex items-center justify-center relative min-h-screen overflow-hidden">

    <!-- Background Image -->
    <img src="{{ asset('background.jpg') }}" 
         alt="Background" 
         class="absolute inset-0 w-full h-full object-cover z-0">

    <!-- Overlay -->
    <div class="absolute inset-0 bg-black/30 z-10"></div>

    <!-- Centered Card -->
    <div class="relative z-20 p-10 bg-white rounded-2xl shadow-xl text-center max-w-4xl">

        <!-- Title -->
        <h1 class="text-10xl md:text-5xl font-bold mb-10 text-gray-800">
            <b>Welcome to Global Restaurant App</b>
        </h1>

        <!-- Login/Register Sections -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 px-6">

            <!-- Login Section -->
            <div class="p-4 border-b md:border-b-0 md:border-r border-gray-200">
                <h2 class="text-2xl font-semibold mb-4">Already have an account?</h2>
                
                @auth
                    <a href="{{ url('/dashboard/' . Auth::user()->role) }}" 
                       class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                       Go to Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" 
                       class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition inline-block">
                       Log in
                    </a>
                @endauth
            </div>

            <!-- Register Section -->
            <div class="p-4 border-t md:border-t-0 md:border-l border-gray-200">
                <h2 class="text-2xl font-semibold mb-4">First time here?</h2>
                <p class="text-gray-700 mb-6">
                    Create your account to discover our best dishes and enjoy special offers.
                </p>
                @if (Route::has('register') && !auth()->check())
                    <a href="{{ route('register') }}" 
                       class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition inline-block">
                       Sign up
                    </a>
                @endif
            </div>

        </div>

    </div>
</div>

</body>
</html>
