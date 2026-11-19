<?php

namespace Tests\Feature;

use App\Models\Absensi;
use App\Models\Departemen;
use App\Models\Karyawan;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Tests\TestCase;

class UserRoleTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_and_employee_roles_are_detected_correctly(): void
    {
        $admin = User::factory()->create([
            'email' => 'admin.role@example.com',
            'role' => 'admin',
        ]);

        $employee = User::factory()->create([
            'email' => 'employee.role@example.com',
            'role' => 'employee',
        ]);

        $this->assertTrue($admin->isAdmin());
        $this->assertFalse($employee->isAdmin());
        $this->assertTrue($employee->isKaryawan());
    }

    public function test_admin_manager_and_employee_can_access_filament_panel(): void
    {
        $admin = User::factory()->create([
            'email' => 'admin.panel@example.com',
            'role' => 'admin',
        ]);

        $manager = User::factory()->create([
            'email' => 'manager.panel@example.com',
            'role' => 'manager',
        ]);

        $employee = User::factory()->create([
            'email' => 'employee.panel@example.com',
            'role' => 'employee',
        ]);

        $this->actingAs($admin)->get('/admin')->assertOk();
        $this->actingAs($manager)->get('/admin')->assertOk();
        $this->actingAs($employee)->get('/admin')->assertOk();
    }

    public function test_resource_policies_enforce_role_permissions(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $manager = User::factory()->create(['role' => 'manager']);
        $employee = User::factory()->create(['role' => 'employee']);
        $otherEmployee = User::factory()->create(['role' => 'employee']);

        $departemen = Departemen::create(['nama_departemen' => 'Operasional']);
        $team = Team::create([
            'departemen_id' => $departemen->id,
            'nama_team' => 'Team A',
        ]);
        $ownKaryawan = Karyawan::create([
            'user_id' => $employee->id,
            'team_id' => $team->id,
            'nama_karyawan' => 'Employee One',
            'email' => 'employee.one@example.com',
            'jabatan' => 'Staff',
        ]);
        $otherKaryawan = Karyawan::create([
            'user_id' => $otherEmployee->id,
            'team_id' => $team->id,
            'nama_karyawan' => 'Employee Two',
            'email' => 'employee.two@example.com',
            'jabatan' => 'Staff',
        ]);
        $absensi = Absensi::create([
            'karyawan_id' => $ownKaryawan->id,
            'tanggal' => now()->toDateString(),
            'status' => 'Hadir',
        ]);

        $this->assertTrue(Gate::forUser($admin)->allows('create', Departemen::class));
        $this->assertTrue(Gate::forUser($admin)->allows('create', Team::class));
        $this->assertTrue(Gate::forUser($admin)->allows('create', Karyawan::class));
        $this->assertTrue(Gate::forUser($admin)->allows('update', $absensi));

        $this->assertTrue(Gate::forUser($manager)->allows('viewAny', Departemen::class));
        $this->assertFalse(Gate::forUser($manager)->allows('create', Departemen::class));
        $this->assertTrue(Gate::forUser($manager)->allows('viewAny', Team::class));
        $this->assertFalse(Gate::forUser($manager)->allows('create', Team::class));
        $this->assertTrue(Gate::forUser($manager)->allows('viewAny', Karyawan::class));
        $this->assertTrue(Gate::forUser($manager)->allows('view', $ownKaryawan));
        $this->assertFalse(Gate::forUser($manager)->allows('update', $ownKaryawan));
        $this->assertFalse(Gate::forUser($manager)->allows('viewAny', Absensi::class));

        $this->assertTrue(Gate::forUser($employee)->allows('viewAny', Karyawan::class));
        $this->assertTrue(Gate::forUser($employee)->allows('view', $ownKaryawan));
        $this->assertTrue(Gate::forUser($employee)->allows('update', $ownKaryawan));
        $this->assertFalse(Gate::forUser($employee)->allows('view', $otherKaryawan));
        $this->assertFalse(Gate::forUser($employee)->allows('update', $otherKaryawan));
        $this->assertFalse(Gate::forUser($employee)->allows('create', Karyawan::class));
        $this->assertFalse(Gate::forUser($employee)->allows('deleteAny', Karyawan::class));
        $this->assertFalse(Gate::forUser($employee)->allows('viewAny', Departemen::class));
        $this->assertFalse(Gate::forUser($employee)->allows('viewAny', Team::class));
        $this->assertFalse(Gate::forUser($employee)->allows('viewAny', Absensi::class));
    }

    public function test_admin_can_use_all_filament_resources_and_reports(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)->get('/admin/departemens/create')->assertOk();
        $this->actingAs($admin)->get('/admin/absensis')->assertOk();
        $this->actingAs($admin)->get('/admin/absensi-laporan')->assertOk();
    }

    public function test_manager_is_limited_to_read_only_master_data_and_employees(): void
    {
        $manager = User::factory()->create(['role' => 'manager']);
        $employee = User::factory()->create(['role' => 'employee']);
        $departemen = Departemen::create(['nama_departemen' => 'Operasional']);
        $team = Team::create([
            'departemen_id' => $departemen->id,
            'nama_team' => 'Team A',
        ]);
        $karyawan = Karyawan::create([
            'user_id' => $employee->id,
            'team_id' => $team->id,
            'nama_karyawan' => 'Employee One',
            'email' => 'employee.one@example.com',
            'jabatan' => 'Staff',
        ]);

        $this->actingAs($manager)
            ->get('/admin/departemens')
            ->assertOk()
            ->assertSee('Team')
            ->assertSee('Karyawan')
            ->assertDontSee('Laporan Absensi');
        $this->actingAs($manager)->get('/admin/teams')->assertOk();
        $this->actingAs($manager)
            ->get('/admin/karyawans')
            ->assertOk()
            ->assertSee('Employee One')
            ->assertDontSee('href="http://localhost:8000/admin/absensis"', false);
        $this->actingAs($manager)->get('/admin/departemens/create')->assertForbidden();
        $this->actingAs($manager)->get("/admin/karyawans/{$karyawan->id}/edit")->assertForbidden();
        $this->actingAs($manager)->get('/admin/teams/create')->assertForbidden();
        $this->actingAs($manager)->get('/admin/absensis')->assertForbidden();
        $this->actingAs($manager)->get('/admin/absensi-laporan')->assertForbidden();
    }

    public function test_employee_sees_and_can_edit_only_their_own_employee_record(): void
    {
        $employee = User::factory()->create(['role' => 'employee']);
        $otherEmployee = User::factory()->create(['role' => 'employee']);
        $departemen = Departemen::create(['nama_departemen' => 'Operasional']);
        $team = Team::create([
            'departemen_id' => $departemen->id,
            'nama_team' => 'Team A',
        ]);
        $ownKaryawan = Karyawan::create([
            'user_id' => $employee->id,
            'team_id' => $team->id,
            'nama_karyawan' => 'Employee One',
            'email' => 'employee.one@example.com',
            'jabatan' => 'Staff',
        ]);
        $otherKaryawan = Karyawan::create([
            'user_id' => $otherEmployee->id,
            'team_id' => $team->id,
            'nama_karyawan' => 'Employee Two',
            'email' => 'employee.two@example.com',
            'jabatan' => 'Staff',
        ]);

        $this->actingAs($employee)
            ->get('/admin/karyawans')
            ->assertOk()
            ->assertSee('Employee One')
            ->assertDontSee('Employee Two')
            ->assertDontSee('href="http://localhost:8000/admin/departemens"', false)
            ->assertDontSee('href="http://localhost:8000/admin/teams"', false)
            ->assertDontSee('href="http://localhost:8000/admin/absensis"', false)
            ->assertDontSee('href="http://localhost:8000/admin/absensi-laporan"', false);
        $this->actingAs($employee)->get("/admin/karyawans/{$ownKaryawan->id}/edit")->assertOk();
        $this->actingAs($employee)->get("/admin/karyawans/{$otherKaryawan->id}/edit")->assertNotFound();
        $this->actingAs($employee)->get('/admin/departemens')->assertForbidden();
        $this->actingAs($employee)->get('/admin/teams')->assertForbidden();
        $this->actingAs($employee)->get('/admin/absensis')->assertForbidden();
    }

    public function test_employee_dashboard_requires_a_matching_user_id(): void
    {
        $employee = User::factory()->create([
            'email' => 'employee.one@example.com',
            'role' => 'employee',
        ]);
        $departemen = Departemen::create(['nama_departemen' => 'Operasional']);
        $team = Team::create([
            'departemen_id' => $departemen->id,
            'nama_team' => 'Team A',
        ]);
        Karyawan::create([
            'team_id' => $team->id,
            'nama_karyawan' => 'Employee One',
            'email' => 'employee.one@example.com',
            'jabatan' => 'Staff',
        ]);

        $this->actingAs($employee)->get('/karyawan')->assertForbidden();
    }

    public function test_unknown_role_cannot_access_filament_panel(): void
    {
        $user = User::factory()->create(['role' => 'guest']);

        $this->actingAs($user)
            ->get('/admin')
            ->assertForbidden();
    }
}
