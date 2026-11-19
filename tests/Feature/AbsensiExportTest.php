<?php

namespace Tests\Feature;

use App\Filament\Exports\AbsensiExporter;
use Tests\TestCase;

class AbsensiExportTest extends TestCase
{
    public function test_absensi_exporter_has_expected_columns(): void
    {
        $columns = AbsensiExporter::getColumns();

        $this->assertNotEmpty($columns);
        $this->assertTrue(collect($columns)->contains(fn ($column) => $column->getName() === 'karyawan.nama_karyawan'));
        $this->assertTrue(collect($columns)->contains(fn ($column) => $column->getName() === 'status'));
    }
}
