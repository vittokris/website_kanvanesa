<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\HasilTb;
use App\Models\MenuTb;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user     = Auth::guard('user')->user();
        $rankings = HasilTb::with('menu')->orderByDesc('skor')->get();
        $menus    = MenuTb::count();

        return view('user.dashboard', compact('user', 'rankings', 'menus'));
    }
}
