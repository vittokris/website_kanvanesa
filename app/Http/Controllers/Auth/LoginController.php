<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::guard('user')->check()) {
            return redirect()->route('ranking');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'user_username' => 'required|string',
            'user_password' => 'required|string',
        ]);

        if (Auth::guard('user')->attempt([
            'user_username' => $credentials['user_username'],
            'password'      => $credentials['user_password'],
        ], $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->route('ranking');
        }

        return back()->withErrors([
            'user_username' => 'Username atau password salah.',
        ])->onlyInput('user_username');
    }

    public function logout(Request $request)
    {
        Auth::guard('user')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
