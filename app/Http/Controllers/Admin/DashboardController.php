<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MenuTb;
use App\Models\PenilaianTb;
use App\Models\HasilTb;
use App\Models\UserTb;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_menu'      => MenuTb::count(),
            'total_user'      => UserTb::count(),
            'total_penilaian' => PenilaianTb::count(),
            'total_hasil'     => HasilTb::count(),
        ];

        $topMenus = HasilTb::with('menu')->orderByDesc('skor')->take(5)->get();

        return view('admin.dashboard', compact('stats', 'topMenus'));
    }
}
