<?php

namespace Tests\Feature\Auth;

use App\Models\Admin;
use App\Models\UserTb;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        $user = UserTb::create([
            'user_name' => 'Pengguna Test',
            'user_username' => 'pengguna_test',
            'user_password' => Hash::make('password123'),
        ]);

        $response = $this->post('/login', [
            'user_username' => $user->user_username,
            'user_password' => 'password123',
        ]);

        $this->assertAuthenticated('user');
        $response->assertRedirect(route('ranking', absolute: false));
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = UserTb::create([
            'user_name' => 'Pengguna Test',
            'user_username' => 'pengguna_test',
            'user_password' => Hash::make('password123'),
        ]);

        $this->post('/login', [
            'user_username' => $user->user_username,
            'user_password' => 'wrong-password',
        ]);

        $this->assertGuest('user');
    }

    public function test_users_can_logout(): void
    {
        $user = UserTb::create([
            'user_name' => 'Pengguna Test',
            'user_username' => 'pengguna_test',
            'user_password' => Hash::make('password123'),
        ]);

        $response = $this->actingAs($user, 'user')->post('/logout');

        $this->assertGuest('user');
        $response->assertRedirect(route('login', absolute: false));
    }

    public function test_admins_can_authenticate_using_the_admin_login_screen(): void
    {
        $admin = Admin::create([
            'admin_name' => 'Admin Test',
            'admin_username' => 'admin_test',
            'admin_password' => Hash::make('admin123'),
        ]);

        $response = $this->post('/admin/login', [
            'admin_username' => $admin->admin_username,
            'admin_password' => 'admin123',
        ]);

        $this->assertAuthenticated('web');
        $response->assertRedirect(route('admin.dashboard', absolute: false));
    }
}
