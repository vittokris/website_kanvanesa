<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserTb;
use App\Models\MenuTb;
use App\Models\Kriteria;
use App\Models\SubKriteria;
use App\Models\PenilaianTb;
use App\Services\SawService;

class PenilaianSeeder extends Seeder
{
    /**
     * Seed dummy ratings for 1 user across all menus and all 5 criteria.
     * After seeding, triggers SAW recalculation so hasil_tb is populated.
     *
     * Dummy rating mapping (sub-kriteria bobot used per menu):
     *   Nasi Liwet Kanvanesa                                       → Rasa:5, Tampilan:4, Harga:4, Porsi:4, Gizi:4
     *   Nasi Lodho                                                 → Rasa:4, Tampilan:5, Harga:2, Porsi:4, Gizi:3
     *   Nasi Sup Ayam, AyamGoreng Laos, Tahu Tempe                 → Rasa:5, Tampilan:4, Harga:3, Porsi:5, Gizi:4
     *   Nasi Nasi Kebuli                                           → Rasa:3, Tampilan:3, Harga:4, Porsi:3, Gizi:3
     *   Nasi Gudeg Komplit                                         → Rasa:4, Tampilan:3, Harga:5, Porsi:4, Gizi:5
     *   Nasi Madura                                                → Rasa:5, Tampilan:3, Harga:3, Porsi:3, Gizi:5
     *   Nasi Uduk Ayam Suwir Kare                                  → Rasa:4, Tampilan:5, Harga:5, Porsi:4, Gizi:4
     *   Nasi Sayur Bening, Ayam Goreng Laos, Botok Telur Asin      → Rasa:5, Tampilan:3, Harga:4, Porsi:3, Gizi:5
     */
    public function run(): void
    {
        // Get the demo user seeded by UserSeeder
        $user = UserTb::where('user_username', 'user_demo')->first();

        if (! $user) {
            $this->command->error('PenilaianSeeder: user_demo tidak ditemukan. Pastikan UserSeeder sudah dijalankan.');
            return;
        }

        $menus     = MenuTb::all()->keyBy('menu_name');
        $kriterias = Kriteria::all()->keyBy('kriteria_name');

        // Sub-kriteria index by [id_kriteria][bobot]
        $subMap = [];
        SubKriteria::all()->each(function ($sub) use (&$subMap) {
            $subMap[$sub->id_kriteria][$sub->bobot_subkriteria] = $sub->id_sub_kriteria;
        });

        // [menu_name => [kriteria_name => bobot_pilihan]]
        $dummyRatings = [
            'Nasi Liwet Kanvanesa' => [
                'Rasa' => 5, 'Tampilan Penyajian' => 4, 'Harga' => 4, 'Porsi' => 4, 'Gizi' => 4,
            ],
            'Ayam Lodho' => [
                'Rasa' => 4, 'Tampilan Penyajian' => 5, 'Harga' => 2, 'Porsi' => 4, 'Gizi' => 3,
            ],
            'Nasi Sup Ayam, Ayam Goreng Laos, Tahu tempe' => [
                'Rasa' => 5, 'Tampilan Penyajian' => 4, 'Harga' => 3, 'Porsi' => 5, 'Gizi' => 4,
            ],
            'Nasi Kebuli' => [
                'Rasa' => 3, 'Tampilan Penyajian' => 3, 'Harga' => 4, 'Porsi' => 3, 'Gizi' => 3,
            ],
            'Nasi Gudeg Komplit' => [
                'Rasa' => 4, 'Tampilan Penyajian' => 3, 'Harga' => 5, 'Porsi' => 4, 'Gizi' => 5,
            ],
            'Nasi Madura' => [
                'Rasa' => 5, 'Tampilan Penyajian' => 3, 'Harga' => 3, 'Porsi' => 3, 'Gizi' => 5,
            ],
            'Nasi Uduk Ayam Suwir Kare' => [
                'Rasa' => 4, 'Tampilan Penyajian' => 5, 'Harga' => 5, 'Porsi' => 4, 'Gizi' => 4,
            ],
            'Nasi Sayur Bening, Ayam Goreng, Botok telur asin' => [
                'Rasa' => 5, 'Tampilan Penyajian' => 3, 'Harga' => 4, 'Porsi' => 3, 'Gizi' => 5,
            ],
        ];

        $count = 0;

        foreach ($dummyRatings as $menuName => $kriteriaRatings) {
            $menu = $menus->get($menuName);
            if (! $menu) {
                $this->command->warn("PenilaianSeeder: Menu '{$menuName}' tidak ditemukan, dilewati.");
                continue;
            }

            foreach ($kriteriaRatings as $kriteriaName => $bobot) {
                $kriteria = $kriterias->get($kriteriaName);
                if (! $kriteria) {
                    $this->command->warn("PenilaianSeeder: Kriteria '{$kriteriaName}' tidak ditemukan, dilewati.");
                    continue;
                }

                $idSubKriteria = $subMap[$kriteria->id_kriteria][$bobot] ?? null;
                if (! $idSubKriteria) {
                    $this->command->warn("PenilaianSeeder: Sub-kriteria bobot={$bobot} untuk '{$kriteriaName}' tidak ditemukan.");
                    continue;
                }

                PenilaianTb::create([
                    'id_user'        => $user->id_user,
                    'id_menu'        => $menu->id_menu,
                    'id_kriteria'    => $kriteria->id_kriteria,
                    'id_subkriteria' => $idSubKriteria,
                ]);

                $count++;
            }
        }

        $this->command->info("PenilaianSeeder: {$count} penilaian dummy berhasil di-seed.");

        // Trigger SAW recalculation so hasil_tb is populated immediately
        $this->command->info('PenilaianSeeder: Menghitung SAW ranking...');
        app(SawService::class)->calculate();
        $this->command->info('PenilaianSeeder: Ranking SAW berhasil dihitung dan disimpan ke hasil_tb.');
    }
}
