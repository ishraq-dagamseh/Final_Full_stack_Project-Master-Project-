<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Show login form
    public function showLoginForm()
    {
        return view('auth.login'); // create this Blade
    }

    // Handle login
    public function login(Request $request)
    {
        // Validate credentials
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        // Attempt login using default guard
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate(); // security: regenerate session
            $user = Auth::user();

            // Redirect based on role
            switch ($user->role) {
                case 'admin':
                    return redirect()->route('dashboard.admin');
                case 'restaurant':
                    return redirect()->route('dashboard.restaurant');
                default:
                    return redirect()->route('dashboard.user');
            }
        }

        // Failed login
        return back()->withErrors([
            'email' => 'Invalid credentials',
        ])->withInput();
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
