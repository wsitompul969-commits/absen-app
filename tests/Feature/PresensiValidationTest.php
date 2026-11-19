<?php

namespace Tests\Feature;

use App\Models\Absensi;
use Tests\TestCase;

class PresensiValidationTest extends TestCase
{
    public function test_absensi_applies_automatic_lateness_and_overtime_rules(): void
    {
        $absensi = new Absensi([
            'karyawan_id' => 1,
            'tanggal' => '2026-11-11',
            'status' => 'Hadir',
            'waktu_masuk' => '2026-11-11 09:15:00',
            'waktu_pulang' => '2026-11-11 18:30:00',
        ]);

        $absensi->applyAutomaticValidation();

        $this->assertStringContainsString('Terlambat', $absensi->keterangan_lembur);
        $this->assertGreaterThan(0, $absensi->jam_lembur);
    }
}
