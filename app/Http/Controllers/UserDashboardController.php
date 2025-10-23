<?php

namespace App\Http\Controllers;
use App\Models\Restaurant;

use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    public function index()
    {
         $restaurants = Restaurant::with('menuItems')->get();

        return view('dashboard.user', compact('restaurants'));
    }
}

