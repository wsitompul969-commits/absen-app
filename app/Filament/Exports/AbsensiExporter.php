<?php

namespace App\Filament\Exports;

use App\Models\Absensi;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class AbsensiExporter extends Exporter
{
    protected static ?string $model = Absensi::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('tanggal')
                ->label('Tanggal'),
            ExportColumn::make('karyawan.nama_karyawan')
                ->label('Karyawan'),
            ExportColumn::make('karyawan.team.nama_team')
                ->label('Team'),
            ExportColumn::make('karyawan.team.departemen.nama_departemen')
                ->label('Departemen'),
            ExportColumn::make('status')
                ->label('Status'),
            ExportColumn::make('waktu_masuk')
                ->label('Waktu Masuk'),
            ExportColumn::make('waktu_pulang')
                ->label('Waktu Pulang'),
            ExportColumn::make('lembur_jam')
                ->label('Lembur (jam)'),
            ExportColumn::make('keterangan_lembur')
                ->label('Keterangan Lembur'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        return 'Ekspor absensi selesai.';
    }
}
