<?php

namespace Tests\Feature;

use App\Models\Departemen;
use App\Models\Karyawan;
use App\Models\Team;
use Tests\TestCase;

class PresensiPageTest extends TestCase
{
    public function test_employee_attendance_page_is_available(): void
    {
        $departemen = Departemen::create(['nama_departemen' => 'Produksi']);
        $team = Team::create([
            'departemen_id' => $departemen->id,
            'nama_team' => 'Team A',
        ]);

        Karyawan::create([
            'team_id' => $team->id,
            'nama_karyawan' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'jabatan' => 'Operator',
        ]);

        $this->get('/presensi')
            ->assertOk()
            ->assertSee('Presensi Karyawan')
            ->assertSee('Budi Santoso');
    }
}
