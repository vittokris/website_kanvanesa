<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,    // Akun admin default
            KriteriaSeeder::class, // 5 kriteria + 25 sub-kriteria
            MenuSeeder::class,     // 8 menu kantin
            UserSeeder::class,     // 1 user demo (user_demo / password123)
            PenilaianSeeder::class, // Penilaian dummy + trigger kalkulasi SAW
        ]);
    }
}
