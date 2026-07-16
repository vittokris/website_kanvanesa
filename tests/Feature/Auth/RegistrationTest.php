<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        $response = $this->post('/register', [
            'user_name' => 'Test User',
            'user_username' => 'test_user',
            'user_password' => 'password123',
            'user_password_confirmation' => 'password123',
        ]);

        $this->assertAuthenticated('user');
        $response->assertRedirect(route('user.dashboard', absolute: false));
    }
}
