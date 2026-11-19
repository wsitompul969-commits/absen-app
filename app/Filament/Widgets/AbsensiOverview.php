<?php

namespace App\Filament\Widgets;

use App\Models\Absensi;
use App\Models\Karyawan;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AbsensiOverview extends BaseWidget
{
    public static function canView(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    protected function getStats(): array
    {
        $today = Carbon::today();

        $totalKaryawan = Karyawan::count();
        $hadir = Absensi::whereDate('tanggal', $today)->where('status', 'Hadir')->count();
        $izin = Absensi::whereDate('tanggal', $today)->where('status', 'Izin')->count();
        $sakit = Absensi::whereDate('tanggal', $today)->where('status', 'Sakit')->count();
        $alpha = Absensi::whereDate('tanggal', $today)->where('status', 'Alpha')->count();

        return [
            Stat::make('Total Karyawan', (string) $totalKaryawan)
                ->description('Jumlah pegawai terdaftar')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('primary'),

            Stat::make('Hadir Hari Ini', (string) $hadir)
                ->description('Karyawan hadir')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('Izin & Sakit', (string) ($izin + $sakit))
                ->description('Karyawan tidak masuk penuh')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color('warning'),

            Stat::make('Alpha', (string) $alpha)
                ->description('Tidak hadir tanpa keterangan')
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('danger'),
        ];
    }
}
