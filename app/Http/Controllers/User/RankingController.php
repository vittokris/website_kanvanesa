<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\HasilTb;
use App\Models\MenuTb;
use App\Models\Kriteria;
use App\Models\PenilaianTb;
use Illuminate\Support\Facades\Auth;

class RankingController extends Controller
{
    /**
     * Public ranking page — accessible to guests and authenticated users alike.
     * Passes per-menu per-kriteria average scores so the view can render star ratings.
     */
    public function index()
    {
        $rankings  = HasilTb::with('menu')->orderByDesc('skor')->get();
        $kriterias = Kriteria::with('subKriterias')->get();
        $totalMenus = MenuTb::count();

        // Build per-menu per-kriteria result for star display
        // Structure: $menuScores[id_menu][id_kriteria] = ['avg' => float, 'rounded' => int, 'sub_name' => string]
        $menuScores = [];

        foreach ($rankings as $hasil) {
            if (! $hasil->menu) continue;
            $idMenu = $hasil->id_menu;

            foreach ($kriterias as $kriteria) {
                $penilaians = PenilaianTb::where('id_menu', $idMenu)
                    ->where('id_kriteria', $kriteria->id_kriteria)
                    ->with('subKriteria')
                    ->get();

                if ($penilaians->count() > 0) {
                    $totalBobot = $penilaians->sum(fn($p) => $p->subKriteria?->bobot_subkriteria ?? 0);
                    $avg        = $totalBobot / $penilaians->count();
                    $rounded    = (int) round($avg);

                    // Find the sub-kriteria name that matches the rounded value
                    $subName = $kriteria->subKriterias
                        ->firstWhere('bobot_subkriteria', $rounded)
                        ?->sub_kriteria_name ?? '—';
                } else {
                    $avg     = 0;
                    $rounded = 0;
                    $subName = 'Belum dinilai';
                }

                $menuScores[$idMenu][$kriteria->id_kriteria] = [
                    'avg'      => $avg,
                    'rounded'  => $rounded,
                    'sub_name' => $subName,
                ];
            }
        }

        // Check if current user is authenticated (user guard)
        $authUser = Auth::guard('user')->user();

        return view('user.ranking', compact(
            'rankings',
            'kriterias',
            'menuScores',
            'totalMenus',
            'authUser'
        ));
    }
}
