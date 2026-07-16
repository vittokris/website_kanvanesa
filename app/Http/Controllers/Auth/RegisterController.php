<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\UserTb;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        if (Auth::guard('user')->check()) {
            return redirect()->route('user.dashboard');
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'user_name'     => 'required|string|max:255',
            'user_username' => 'required|string|max:255|unique:user_tb,user_username',
            'user_password' => 'required|string|min:6|confirmed',
        ]);

        $user = UserTb::create([
            'user_name'     => $validated['user_name'],
            'user_username' => $validated['user_username'],
            'user_password' => Hash::make($validated['user_password']),
        ]);

        Auth::guard('user')->login($user);
        $request->session()->regenerate();

        return redirect()->route('user.dashboard')
            ->with('success', 'Registrasi berhasil! Selamat datang, ' . $user->user_name . '.');
    }
}
