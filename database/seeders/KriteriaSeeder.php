<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kriteria;
use App\Models\SubKriteria;

class KriteriaSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'kriteria_name' => 'Rasa',
                'sub_kriterias' => [
                    ['sub_kriteria_name' => 'Tidak Suka',    'bobot_subkriteria' => 1],
                    ['sub_kriteria_name' => 'Kurang Suka',   'bobot_subkriteria' => 2],
                    ['sub_kriteria_name' => 'Cukup',         'bobot_subkriteria' => 3],
                    ['sub_kriteria_name' => 'Suka',          'bobot_subkriteria' => 4],
                    ['sub_kriteria_name' => 'Sangat Suka',   'bobot_subkriteria' => 5],
                ],
            ],
            [
                'kriteria_name' => 'Tampilan Penyajian',
                'sub_kriterias' => [
                    ['sub_kriteria_name' => 'Tidak Menarik',   'bobot_subkriteria' => 1],
                    ['sub_kriteria_name' => 'Kurang Menarik',  'bobot_subkriteria' => 2],
                    ['sub_kriteria_name' => 'Cukup Menarik',   'bobot_subkriteria' => 3],
                    ['sub_kriteria_name' => 'Menarik',         'bobot_subkriteria' => 4],
                    ['sub_kriteria_name' => 'Sangat Menarik',  'bobot_subkriteria' => 5],
                ],
            ],
            [
                'kriteria_name' => 'Harga',
                'sub_kriterias' => [
                    ['sub_kriteria_name' => 'Sangat Mahal',  'bobot_subkriteria' => 1],
                    ['sub_kriteria_name' => 'Mahal',         'bobot_subkriteria' => 2],
                    ['sub_kriteria_name' => 'Terjangkau',    'bobot_subkriteria' => 3],
                    ['sub_kriteria_name' => 'Murah',         'bobot_subkriteria' => 4],
                    ['sub_kriteria_name' => 'Sangat Murah',  'bobot_subkriteria' => 5],
                ],
            ],
            [
                'kriteria_name' => 'Porsi',
                'sub_kriterias' => [
                    ['sub_kriteria_name' => 'Sangat Sedikit', 'bobot_subkriteria' => 1],
                    ['sub_kriteria_name' => 'Sedikit',        'bobot_subkriteria' => 2],
                    ['sub_kriteria_name' => 'Sedang',         'bobot_subkriteria' => 3],
                    ['sub_kriteria_name' => 'Banyak',         'bobot_subkriteria' => 4],
                    ['sub_kriteria_name' => 'Sangat Banyak',  'bobot_subkriteria' => 5],
                ],
            ],
            [
                'kriteria_name' => 'Gizi',
                'sub_kriterias' => [
                    ['sub_kriteria_name' => 'Tidak Seimbang',   'bobot_subkriteria' => 1],
                    ['sub_kriteria_name' => 'Kurang Seimbang',  'bobot_subkriteria' => 2],
                    ['sub_kriteria_name' => 'Cukup Seimbang',   'bobot_subkriteria' => 3],
                    ['sub_kriteria_name' => 'Seimbang',         'bobot_subkriteria' => 4],
                    ['sub_kriteria_name' => 'Sangat Seimbang',  'bobot_subkriteria' => 5],
                ],
            ],
        ];

        foreach ($data as $kriteriaData) {
            $kriteria = Kriteria::create(['kriteria_name' => $kriteriaData['kriteria_name']]);

            foreach ($kriteriaData['sub_kriterias'] as $sub) {
                SubKriteria::create([
                    'id_kriteria'       => $kriteria->id_kriteria,
                    'sub_kriteria_name' => $sub['sub_kriteria_name'],
                    'bobot_subkriteria' => $sub['bobot_subkriteria'],
                ]);
            }

            $this->command->info("Kriteria '{$kriteriaData['kriteria_name']}' seeded with 5 sub-kriteria.");
        }
    }
}
