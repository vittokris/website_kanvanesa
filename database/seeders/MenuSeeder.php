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
        'menu_name' => 'Nasi Liwet Kanvanesa',
        'menu_description' => 'Nasi Liwet + Ayam Bakar + Tempe Bacem + Sayur + Sambal.',
        'menu_price' => 25000,
    ],
    [
        'menu_name' => 'Ayam Lodho',
        'menu_description' => 'Nasi Putih + Ayam Lodho + Urap-Urap + Telur + Lalapan + Sambal.',
        'menu_price' => 27000,
    ],
    [
        'menu_name' => 'Nasi Sup Ayam, Ayam Goreng Laos, Tahu Tempe',
        'menu_description' => 'Nasi Putih + Sup Ayam + Ayam Goreng Laos + Tahu Tempe + Lalapan + Sambal Bawang.',
        'menu_price' => 25000,
    ],
    [
        'menu_name' => 'Nasi Kebuli',
        'menu_description' => 'Nasi Kebuli + Ayam Goreng + Kentang Mustofa + Perkedel + Acar + Lalapan.',
        'menu_price' => 30000,
    ],
    [
        'menu_name' => 'Nasi Gudeg Komplit',
        'menu_description' => 'Nasi Putih + Gudeg + Ayam Opor + Tempe Bacem + Telur + Krecek + Sambal + Lalapan.',
        'menu_price' => 28000,
    ],
    [
        'menu_name' => 'Nasi Madura',
        'menu_description' => 'Nasi Putih + Daging Bumbu Madura + Tempe Goreng + Tumis Sayur + Sambal + Kerupuk.',
        'menu_price' => 30000,
    ],
    [
        'menu_name' => 'Nasi Uduk Ayam Suwir Kare',
        'menu_description' => 'Nasi Uduk + Ayam Suwir Kare + Telur + Bihun + Perkedel + Sambal + Lalapan.',
        'menu_price' => 25000,
    ],
    [
        'menu_name' => 'Nasi Sayur Bening, Ayam Goreng, Botok Telur Asin',
        'menu_description' => 'Nasi Putih + Sayur Bening + Ayam Goreng + Botok Telur Asin + Sambal + Lalapan.',
        'menu_price' => 26000,
    ],
    [
        'menu_name' => 'Nasi Rawon Daging',
        'menu_description' => 'Nasi Putih + Rawon Daging + Tauge Pendek + Telur Asin + Kerupuk Udang + Sambal.',
        'menu_price' => 32000,
    ],
    [
        'menu_name' => 'Nasi Soto Ayam Lamongan',
        'menu_description' => 'Nasi Putih + Soto Ayam + Telur Rebus + Perkedel + Sambal + Kerupuk.',
        'menu_price' => 26000,
    ],
    [
        'menu_name' => 'Nasi Pecel Ayam Goreng',
        'menu_description' => 'Nasi Putih + Pecel Sayur + Ayam Goreng + Tempe + Rempeyek + Sambal.',
        'menu_price' => 25000,
    ],
    [
        'menu_name' => 'Nasi Campur Bali',
        'menu_description' => 'Nasi Putih + Ayam Betutu + Sate Lilit + Lawar + Sambal Matah.',
        'menu_price' => 30000,
    ],
    [
        'menu_name' => 'Nasi Rendang Sapi',
        'menu_description' => 'Nasi Putih + Rendang Sapi + Telur Balado + Daun Singkong + Sambal Hijau.',
        'menu_price' => 35000,
    ],
    [
        'menu_name' => 'Nasi Ayam Bakar Madu',
        'menu_description' => 'Nasi Putih + Ayam Bakar Madu + Tumis Kangkung + Tahu Goreng + Sambal.',
        'menu_price' => 29000,
    ],
    [
        'menu_name' => 'Nasi Ayam Geprek',
        'menu_description' => 'Nasi Putih + Ayam Geprek + Timun + Tempe Goreng + Sambal Geprek.',
        'menu_price' => 25000,
    ],
    [
        'menu_name' => 'Nasi Lele Goreng',
        'menu_description' => 'Nasi Putih + Lele Goreng + Lalapan + Tempe + Sambal Terasi.',
        'menu_price' => 24000,
    ],
    [
        'menu_name' => 'Nasi Bandeng Presto',
        'menu_description' => 'Nasi Putih + Bandeng Presto + Tahu Goreng + Sayur Asem + Sambal.',
        'menu_price' => 28000,
    ],
    [
        'menu_name' => 'Nasi Ikan Tongkol Balado',
        'menu_description' => 'Nasi Putih + Tongkol Balado + Tumis Buncis + Tempe Goreng + Sambal.',
        'menu_price' => 27000,
    ],
    [
        'menu_name' => 'Nasi Ayam Kecap',
        'menu_description' => 'Nasi Putih + Ayam Kecap + Capcay + Tahu Goreng + Sambal.',
        'menu_price' => 25000,
    ],
    [
        'menu_name' => 'Nasi Semur Daging',
        'menu_description' => 'Nasi Putih + Semur Daging + Kentang + Telur + Acar + Sambal.',
        'menu_price' => 32000,
    ],
    [
        'menu_name' => 'Nasi Empal Gepuk',
        'menu_description' => 'Nasi Putih + Empal Gepuk + Urap Sayur + Tempe Bacem + Sambal.',
        'menu_price' => 32000,
    ],
    [
        'menu_name' => 'Nasi Opor Ayam',
        'menu_description' => 'Nasi Putih + Opor Ayam + Telur + Sambal Goreng Kentang + Kerupuk.',
        'menu_price' => 27000,
    ],
    [
        'menu_name' => 'Nasi Ayam Teriyaki',
        'menu_description' => 'Nasi Putih + Ayam Teriyaki + Tumis Sayur + Telur Dadar + Saus Wijen.',
        'menu_price' => 30000,
    ],
    [
        'menu_name' => 'Nasi Ayam Rica-Rica',
        'menu_description' => 'Nasi Putih + Ayam Rica-Rica + Tumis Kangkung + Tempe Goreng + Sambal.',
        'menu_price' => 29000,
    ],
    [
        'menu_name' => 'Nasi Cumi Hitam',
        'menu_description' => 'Nasi Putih + Cumi Masak Hitam + Lalapan + Sambal + Kerupuk.',
        'menu_price' => 34000,
    ],
    [
        'menu_name' => 'Nasi Udang Asam Manis',
        'menu_description' => 'Nasi Putih + Udang Asam Manis + Capcay + Sambal + Kerupuk.',
        'menu_price' => 34000,
    ],
    [
        'menu_name' => 'Nasi Ayam Woku',
        'menu_description' => 'Nasi Putih + Ayam Woku + Tumis Kangkung + Tempe + Sambal.',
        'menu_price' => 30000,
    ],
    [
        'menu_name' => 'Nasi Telur Balado Komplit',
        'menu_description' => 'Nasi Putih + Telur Balado + Tempe Goreng + Sayur + Sambal.',
        'menu_price' => 22000,
    ],
    [
        'menu_name' => 'Nasi Tahu Tempe Bacem',
        'menu_description' => 'Nasi Putih + Tahu Bacem + Tempe Bacem + Sayur Lodeh + Sambal.',
        'menu_price' => 20000,
    ],
    [
        'menu_name' => 'Nasi Ayam Goreng Kalasan',
        'menu_description' => 'Nasi Putih + Ayam Goreng Kalasan + Lalapan + Sambal + Tahu Goreng.',
        'menu_price' => 28000,
    ],
    [
        'menu_name' => 'Nasi Sate Ayam',
        'menu_description' => 'Nasi Putih + Sate Ayam + Lontong + Sambal Kacang + Acar.',
        'menu_price' => 32000,
    ],
    [
        'menu_name' => 'Nasi Sate Kambing',
        'menu_description' => 'Nasi Putih + Sate Kambing + Sambal Kecap + Acar + Kerupuk.',
        'menu_price' => 36000,
    ],
    [
        'menu_name' => 'Nasi Bakso Kuah',
        'menu_description' => 'Nasi Putih + Bakso Kuah + Tahu + Sambal + Kerupuk.',
        'menu_price' => 25000,
    ],
    [
        'menu_name' => 'Nasi Sop Buntut',
        'menu_description' => 'Nasi Putih + Sop Buntut + Wortel + Kentang + Sambal + Emping.',
        'menu_price' => 38000,
    ],
    [
        'menu_name' => 'Nasi Ayam Goreng Lengkuas',
        'menu_description' => 'Nasi Putih + Ayam Goreng Lengkuas + Tempe + Lalapan + Sambal.',
        'menu_price' => 28000,
    ],
    [
        'menu_name' => 'Nasi Paru Balado',
        'menu_description' => 'Nasi Putih + Paru Balado + Urap Sayur + Sambal + Kerupuk.',
        'menu_price' => 34000,
    ],
    [
        'menu_name' => 'Nasi Dendeng Balado',
        'menu_description' => 'Nasi Putih + Dendeng Balado + Daun Singkong + Sambal Hijau.',
        'menu_price' => 36000,
    ],
    [
        'menu_name' => 'Nasi Ayam Serundeng',
        'menu_description' => 'Nasi Putih + Ayam Serundeng + Tempe Goreng + Lalapan + Sambal.',
        'menu_price' => 28000,
    ],
    [
        'menu_name' => 'Nasi Capcay Ayam',
        'menu_description' => 'Nasi Putih + Capcay Ayam + Telur Dadar + Kerupuk + Sambal.',
        'menu_price' => 26000,
    ],
    [
        'menu_name' => 'Nasi Kare Ayam',
        'menu_description' => 'Nasi Putih + Kare Ayam + Kentang + Telur + Sambal.',
        'menu_price' => 29000,
    ],
    [
        'menu_name' => 'Nasi Bistik Ayam',
        'menu_description' => 'Nasi Putih + Ayam Bistik + Kentang Goreng + Wortel + Buncis + Saus.',
        'menu_price' => 31000,
    ],
    [
        'menu_name' => 'Nasi Ayam Mentega',
        'menu_description' => 'Nasi Putih + Ayam Saus Mentega + Capcay + Sambal.',
        'menu_price' => 30000,
    ],
    [
        'menu_name' => 'Nasi Iga Bakar',
        'menu_description' => 'Nasi Putih + Iga Bakar + Lalapan + Sambal + Sup Bening.',
        'menu_price' => 38000,
    ],
    [
        'menu_name' => 'Nasi Gurame Goreng',
        'menu_description' => 'Nasi Putih + Gurame Goreng + Cah Kangkung + Sambal + Lalapan.',
        'menu_price' => 37000,
    ],
    [
        'menu_name' => 'Nasi Ayam Bumbu Rujak',
        'menu_description' => 'Nasi Putih + Ayam Bumbu Rujak + Tempe Goreng + Sayur + Sambal.',
        'menu_price' => 29000,
    ],
];

        foreach ($menus as $data) {
            MenuTb::create($data);
        }

        $this->command->info('MenuSeeder: ' . count($menus) . ' menu berhasil di-seed.');
    }
}
