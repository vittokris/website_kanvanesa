<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\MenuTb;
use App\Models\Kriteria;
use App\Models\PenilaianTb;
use App\Services\SawService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenilaianController extends Controller
{
    public function __construct(private SawService $sawService) {}

    public function index()
    {
        $user     = Auth::guard('user')->user();
        $menus    = MenuTb::all();
        $kriterias = Kriteria::with('subKriterias')->get();

        // Get menus already rated by this user (all 5 criteria)
        $ratedMenuIds = PenilaianTb::where('id_user', $user->id_user)
            ->select('id_menu')
            ->groupBy('id_menu')
            ->havingRaw('COUNT(DISTINCT id_kriteria) = ?', [$kriterias->count()])
            ->pluck('id_menu')
            ->toArray();

        return view('user.penilaian.index', compact('menus', 'kriterias', 'ratedMenuIds', 'user'));
    }

    public function store(Request $request)
    {
        $user = Auth::guard('user')->user();

        $request->validate([
            'id_menu'          => 'required|exists:menu_tb,id_menu',
            'ratings'          => 'required|array',
            'ratings.*'        => 'required|exists:sub_kriteria,id_sub_kriteria',
        ]);

        $menuId  = $request->input('id_menu');
        $ratings = $request->input('ratings'); // [id_kriteria => id_sub_kriteria]

        foreach ($ratings as $idKriteria => $idSubKriteria) {
            PenilaianTb::updateOrCreate(
                [
                    'id_user'    => $user->id_user,
                    'id_menu'    => $menuId,
                    'id_kriteria'=> $idKriteria,
                ],
                [
                    'id_subkriteria' => $idSubKriteria,
                ]
            );
        }

        // Trigger automatic SAW recalculation in the background
        // after every successful rating submission.
        $this->sawService->calculate();

        return redirect()->route('user.penilaian')
            ->with('success', 'Penilaian berhasil disimpan!');
    }
}
