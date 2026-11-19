<?php

namespace Database\Seeders;

use App\Models\Departemen;
use App\Models\Karyawan;
use App\Models\Team;
use Illuminate\Database\Seeder;

class DepartemenTeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departemen = [
            'IT' => ['Web Development', 'Support IT'],
            'HR' => ['Recruitment', 'Komunikasi Internal'],
            'Operasional' => ['Produksi', 'Logistik'],
        ];

        foreach ($departemen as $namaDepartemen => $teams) {
            $departemenModel = Departemen::firstOrCreate([
                'nama_departemen' => $namaDepartemen,
            ]);

            foreach ($teams as $namaTeam) {
                $team = Team::firstOrCreate([
                    'departemen_id' => $departemenModel->id,
                    'nama_team' => $namaTeam,
                ]);

                $sampleKaryawan = match ($namaTeam) {
                    'Web Development' => [
                        ['nama_karyawan' => 'Andi Pratama', 'email' => 'andi@absensi.test', 'jabatan' => 'Frontend Developer'],
                        ['nama_karyawan' => 'Rina Sari', 'email' => 'rina@absensi.test', 'jabatan' => 'Backend Developer'],
                    ],
                    'Support IT' => [
                        ['nama_karyawan' => 'Dimas Putra', 'email' => 'dimas@absensi.test', 'jabatan' => 'IT Support'],
                    ],
                    'Recruitment' => [
                        ['nama_karyawan' => 'Siti Aisyah', 'email' => 'siti@absensi.test', 'jabatan' => 'Recruitment Officer'],
                    ],
                    'Komunikasi Internal' => [
                        ['nama_karyawan' => 'Budi Santoso', 'email' => 'budi@absensi.test', 'jabatan' => 'HR Staff'],
                    ],
                    'Produksi' => [
                        ['nama_karyawan' => 'Lukman Hakim', 'email' => 'lukman@absensi.test', 'jabatan' => 'Supervisor Produksi'],
                    ],
                    'Logistik' => [
                        ['nama_karyawan' => 'Nadia Putri', 'email' => 'nadia@absensi.test', 'jabatan' => 'Logistik'],
                    ],
                    default => [],
                };

                foreach ($sampleKaryawan as $karyawan) {
                    Karyawan::firstOrCreate(
                        ['email' => $karyawan['email']],
                        [
                            'team_id' => $team->id,
                            'nama_karyawan' => $karyawan['nama_karyawan'],
                            'jabatan' => $karyawan['jabatan'],
                        ],
                    );
                }
            }
        }
    }
}
