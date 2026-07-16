<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MenuTb;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $menus = [
            [
                'menu_name'        => 'Nasi Liwet Kanvanesa',
                'menu_description' => 'Nasi Liwet + Ayam bakar + Tempe Bacem + Sayur + Sambal.',
                'menu_price'       => 25000,
            ],
            [
                'menu_name'        => 'Ayam Lodho',
                'menu_description' => 'Nasi Putih + Ayam Lodho + Urap-urap + Telur + Lalapan + Sambal.',
                'menu_price'       => 27000,
            ],
            [
                'menu_name'        => 'Nasi Sup Ayam, Ayam Goreng Laos, Tahu tempe',
                'menu_description' => 'Nasi Putih + Nasi Sup Ayam + Ayam Goreng Laos + Tahu tempe + Lalapan + Sambal Bawang.',
                'menu_price'       => 25000,
            ],
            [
                'menu_name'        => 'Nasi Kebuli',
                'menu_description' => 'Nasi Biryani + Ayam Goreng + Kentang Mustofa + Perkedel + Acar + Lalapan.',
                'menu_price'       => 30000,
            ],
            [
                'menu_name'        => 'Nasi Gudeg Komplit',
                'menu_description' => 'Nasi Putih + Ayam Opor + Tempe Bacem, Telur Bacem + Krecek + Sayur Nangka + Sambal + Lalapan.',
                'menu_price'       => 28000,
            ],
            [
                'menu_name'        => 'Nasi Madura',
                'menu_description' => 'Nasi Putih + Babat + Udang Goreng + Tempe Goreng + Tumis Sayur + Sambal Pencit dan Sambal Bawang + Serundeng + Kerupuk + Lalapan.',
                'menu_price'       => 30000,
            ],
            [
                'menu_name'        => 'Nasi Uduk Ayam Suwir Kare',
                'menu_description' => 'Nasi Putih + Tempe Goreng + Ayam Suwir Kare + Telur dan Bihun + Perkedel + Sambal + Lalapan.',
                'menu_price'       => 25000,
            ],
            [
                'menu_name'        => 'Nasi Sayur Bening, Ayam Goreng, Botok telur asin',
                'menu_description' => 'Nasi Putih + Ayam Goreng + Sayur Bening + Botok Telur Asin + Sambel Goreng Tempe + Sambel Bawang + Lalapan.',
                'menu_price'       => 26000,
            ],
        ];

        foreach ($menus as $data) {
            MenuTb::create($data);
        }

        $this->command->info('MenuSeeder: ' . count($menus) . ' menu berhasil di-seed.');
    }
}
