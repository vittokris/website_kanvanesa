<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\UserTb;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        UserTb::create([
            'user_username' => 'user_demo',
            'user_password' => Hash::make('password123'),
            'user_name'     => 'Pengguna Demo',
        ]);

        $this->command->info('UserSeeder: user_demo (password: password123) berhasil di-seed.');
    }
}
