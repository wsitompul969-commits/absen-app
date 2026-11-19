<?php

namespace App\Filament\Widgets;

use App\Models\Absensi;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class AbsensiStatusChart extends ChartWidget
{
    protected ?string $heading = 'Statistik Kehadiran Bulan Ini';

    public static function canView(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    protected function getData(): array
    {
        $statusData = Absensi::query()
            ->whereMonth('tanggal', Carbon::now()->month)
            ->whereYear('tanggal', Carbon::now()->year)
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $labels = ['Hadir', 'Izin', 'Sakit', 'Alpha'];
        $data = [];

        foreach ($labels as $label) {
            $data[] = $statusData[$label] ?? 0;
        }

        return [
            'datasets' => [[
                'label' => 'Jumlah',
                'data' => $data,
                'backgroundColor' => ['#10b981', '#f59e0b', '#3b82f6', '#ef4444'],
                'borderRadius' => 8,
            ]],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
