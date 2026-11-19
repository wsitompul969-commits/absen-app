<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class LoginPageTest extends TestCase
{
    public function test_login_choice_page_is_available(): void
    {
        $this->get('/login')
            ->assertOk()
            ->assertSee('Login')
            ->assertSee('Admin')
            ->assertSee('Karyawan');
    }

    public function test_admin_login_page_is_available(): void
    {
        $this->get('/admin/login')
            ->assertOk();
    }

    public function test_admin_user_can_access_admin_dashboard(): void
    {
        $admin = User::factory()->create([
            'email' => 'admin@test.com',
            'password' => 'password123',
            'role' => 'admin',
        ]);

        $this->actingAs($admin)
            ->get('/admin')
            ->assertOk();
    }
}
