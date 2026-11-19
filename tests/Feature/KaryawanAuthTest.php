<?php

namespace Tests\Feature;

use App\Models\Departemen;
use App\Models\Karyawan;
use App\Models\Team;
use App\Models\User;
use Tests\TestCase;

class KaryawanAuthTest extends TestCase
{
    public function test_employee_login_page_is_accessible(): void
    {
        $this->get('/karyawan/login')
            ->assertOk()
            ->assertSee('Login Karyawan');
    }

    public function test_employee_can_access_employee_dashboard_after_login(): void
    {
        $user = User::factory()->create([
            'email' => 'karyawan.login@example.com',
            'role' => 'staff',
        ]);

        $departemen = Departemen::create(['nama_departemen' => 'Operasional']);
        $team = Team::create([
            'departemen_id' => $departemen->id,
            'nama_team' => 'Team B',
        ]);

        Karyawan::create([
            'user_id' => $user->id,
            'team_id' => $team->id,
            'nama_karyawan' => 'Dewi Putri',
            'email' => 'karyawan.login@example.com',
            'jabatan' => 'Staff',
        ]);

        $this->actingAs($user)
            ->get('/karyawan')
            ->assertOk();
    }
}
