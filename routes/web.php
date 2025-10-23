<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\MenuItemController;
use App\Http\Controllers\MenuCategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Auth\LoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public route
Route::get('/', fn() => view('welcome'))->name('home');

// Auth routes
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Authenticated routes
Route::middleware('auth')->group(function () {

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    
    
    // User dashboard
    Route::middleware('role:user')->group(function () {
        Route::get('/dashboard/user', [UserDashboardController::class, 'index'])->name('dashboard.user');

        // Place and cancel orders (from user side)
        Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
        Route::delete('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
    });

    // Admin dashboard
    Route::middleware('role:admin')->group(function () {
        Route::get('/dashboard/admin', [AdminDashboardController::class, 'index'])->name('dashboard.admin');
    });

    // Restaurant dashboard
    Route::middleware('role:restaurant')->group(function () {

        // Restaurant main dashboard
        Route::get('/dashboard/restaurant', [RestaurantController::class, 'index'])
            ->name('dashboard.restaurant');

        // Restaurant orders
        Route::get('/dashboard/restaurant/orders', [OrderController::class, 'index'])
            ->name('restaurant.orders');

        // Update order status (restaurant side)
        Route::put('/dashboard/restaurant/orders/{id}/status', [OrderController::class, 'updateStatus'])
            ->name('restaurant.orders.updateStatus');

        // Menu items CRUD
        Route::get('/dashboard/restaurant/menu-items', [MenuItemController::class, 'index'])
            ->name('menu-items.index');
        Route::get('/dashboard/restaurant/menu-items/create', [MenuItemController::class, 'create'])
            ->name('menu-items.create');
        Route::post('/dashboard/restaurant/menu-items', [MenuItemController::class, 'store'])
            ->name('menu-items.store');
        Route::get('/dashboard/restaurant/menu-items/{id}/edit', [MenuItemController::class, 'edit'])
            ->name('menu-items.edit');
        Route::put('/dashboard/restaurant/menu-items/{id}', [MenuItemController::class, 'update'])
            ->name('menu-items.update');
        Route::delete('/dashboard/restaurant/menu-items/{id}', [MenuItemController::class, 'destroy'])
            ->name('menu-items.destroy');

    });

});

Route::post('/basket/add', [App\Http\Controllers\BasketController::class, 'add'])->name('basket.add');
Route::delete('/basket/remove', [App\Http\Controllers\BasketController::class, 'remove'])->name('basket.remove');

Route::post('/orders', [App\Http\Controllers\OrderController::class, 'store'])->name('orders.store');
Route::delete('/orders/cancel/{id}', [App\Http\Controllers\OrderController::class, 'cancel'])->name('orders.cancel');


require __DIR__.'/auth.php';
