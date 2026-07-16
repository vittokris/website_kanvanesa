<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::create([
            'admin_username' => 'admin',
            'admin_password' => Hash::make('admin123'),
            'admin_name'     => 'Administrator Kanvanesa',
        ]);

        $this->command->info('Admin seeded: username=admin | password=admin123');
    }
}
