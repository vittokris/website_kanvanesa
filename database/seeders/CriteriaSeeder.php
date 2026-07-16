<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $criterias = [
            ['name' => 'Rasa', 'code' => 'C1', 'type' => 'benefit', 'weight' => 0.0],
            ['name' => 'Harga', 'code' => 'C2', 'type' => 'benefit', 'weight' => 0.0],
            ['name' => 'Porsi', 'code' => 'C3', 'type' => 'benefit', 'weight' => 0.0],
            ['name' => 'Tampilan Penyajian', 'code' => 'C4', 'type' => 'benefit', 'weight' => 0.0],
            ['name' => 'Gizi', 'code' => 'C5', 'type' => 'benefit', 'weight' => 0.0],
        ];

        foreach ($criterias as $criteria) {
            \App\Models\Criteria::create($criteria);
        }
    }
}
