<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SawService;
use App\Models\PenilaianTb;

class SawController extends Controller
{
    public function __construct(private SawService $sawService) {}

    /**
     * Display the current SAW ranking results.
     * Data is read directly from hasil_tb (auto-updated on every user rating).
     */
    public function index()
    {
        $results = $this->sawService->getResults();
        $hasData = PenilaianTb::exists();
        $calculation = $this->sawService->getCalculationBreakdown();

        return view('admin.saw.index', compact('results', 'hasData', 'calculation'));
    }
}
