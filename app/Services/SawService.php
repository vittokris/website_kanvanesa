<?php

namespace App\Services;

use App\Models\HasilTb;
use App\Models\Kriteria;
use App\Models\MenuTb;
use App\Models\PenilaianTb;
use Illuminate\Support\Facades\DB;

class SawService
{
    /**
     * Bobot kriteria dari hasil perhitungan AHP.
     * Key harus sama dengan kriteria_name pada tabel kriteria.
     */
    const AHP_WEIGHTS = [
        'Rasa'               => 0.358,
        'Tampilan Penyajian' => 0.233,
        'Harga'              => 0.192,
        'Porsi'              => 0.112,
        'Gizi'               => 0.105,
    ];

    /**
     * Execute the full SAW calculation and persist results to hasil_tb.
     * Called automatically on every user rating submission.
     */
    public function calculate(): void
    {
        $calculation = $this->getCalculationBreakdown();

        if ($calculation['menus']->isEmpty() || $calculation['kriterias']->isEmpty()) {
            return;
        }

        $isMysql = DB::connection()->getDriverName() === 'mysql';

        if ($isMysql) {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
        }

        HasilTb::truncate();

        if ($isMysql) {
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        }

        foreach ($calculation['preferences'] as $menuId => $skor) {
            HasilTb::create([
                'id_menu' => $menuId,
                'skor'    => $skor,
            ]);
        }
    }

    /**
     * Ambil hasil ranking terakhir, diurutkan dari skor tertinggi.
     */
    public function getResults(): \Illuminate\Database\Eloquent\Collection
    {
        return HasilTb::with('menu')->orderByDesc('skor')->get();
    }

    /**
     * Build the same SAW detail used by calculate(), without saving it.
     *
     * Alur:
     * 1. Ambil rata-rata bobot sub-kriteria per menu dan kriteria.
     * 2. Normalisasi benefit: r = nilai rata-rata / nilai rata-rata tertinggi.
     * 3. Hitung kontribusi: kontribusi = r x bobot AHP.
     * 4. Jumlahkan seluruh kontribusi menjadi skor akhir SAW.
     */
    public function getCalculationBreakdown(): array
    {
        $menus = MenuTb::orderBy('id_menu')->get();
        $kriterias = Kriteria::orderBy('id_kriteria')->get();

        $rawScores = [];
        $counts = [];

        foreach ($menus as $menu) {
            foreach ($kriterias as $kriteria) {
                $penilaians = PenilaianTb::where('id_menu', $menu->id_menu)
                    ->where('id_kriteria', $kriteria->id_kriteria)
                    ->with('subKriteria')
                    ->get();

                $count = $penilaians->count();
                $counts[$menu->id_menu][$kriteria->id_kriteria] = $count;
                $rawScores[$menu->id_menu][$kriteria->id_kriteria] = $count > 0
                    ? $penilaians->sum(fn($p) => $p->subKriteria?->bobot_subkriteria ?? 0) / $count
                    : 0;
            }
        }

        $maxPerKriteria = [];

        foreach ($kriterias as $kriteria) {
            $nilaiPerMenu = [];

            foreach ($menus as $menu) {
                $nilaiPerMenu[] = $rawScores[$menu->id_menu][$kriteria->id_kriteria] ?? 0;
            }

            $maxPerKriteria[$kriteria->id_kriteria] = count($nilaiPerMenu) > 0 ? max($nilaiPerMenu) : 0;
        }

        $normalized = [];
        $contributions = [];
        $preferences = [];
        $byMenu = [];

        foreach ($menus as $menu) {
            $pref = 0.0;
            $criteriaDetail = [];

            foreach ($kriterias as $kriteria) {
                $raw = $rawScores[$menu->id_menu][$kriteria->id_kriteria] ?? 0;
                $max = $maxPerKriteria[$kriteria->id_kriteria] ?? 0;
                $normalValue = $max > 0 ? $raw / $max : 0;
                $weight = self::AHP_WEIGHTS[$kriteria->kriteria_name] ?? 0;
                $contribution = $normalValue * $weight;

                $normalized[$menu->id_menu][$kriteria->id_kriteria] = $normalValue;
                $contributions[$menu->id_menu][$kriteria->id_kriteria] = $contribution;
                $pref += $contribution;

                $criteriaDetail[$kriteria->id_kriteria] = [
                    'name' => $kriteria->kriteria_name,
                    'raw' => $raw,
                    'max' => $max,
                    'normalized' => $normalValue,
                    'weight' => $weight,
                    'contribution' => $contribution,
                    'count' => $counts[$menu->id_menu][$kriteria->id_kriteria] ?? 0,
                ];
            }

            $preferences[$menu->id_menu] = round($pref, 6);
            $byMenu[$menu->id_menu] = [
                'menu' => $menu,
                'criteria' => $criteriaDetail,
                'score' => round($pref, 6),
                'total_count' => array_sum($counts[$menu->id_menu] ?? []),
            ];
        }

        return [
            'menus' => $menus,
            'kriterias' => $kriterias,
            'weights' => self::AHP_WEIGHTS,
            'raw' => $rawScores,
            'counts' => $counts,
            'maxPerKriteria' => $maxPerKriteria,
            'normalized' => $normalized,
            'contributions' => $contributions,
            'preferences' => $preferences,
            'byMenu' => $byMenu,
        ];
    }
}
