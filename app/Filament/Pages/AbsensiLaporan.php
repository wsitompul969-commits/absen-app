<?php

namespace App\Filament\Pages;

use App\Models\Absensi;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AbsensiLaporan extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-document-chart-bar';

    protected string $view = 'filament.pages.absensi-laporan';

    protected static ?string $navigationLabel = 'Laporan Absensi';

    protected static ?string $title = 'Laporan Absensi';

    protected static ?int $navigationSort = 6;

    public ?string $tanggal = null;

    public static function canAccess(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    public function mount(): void
    {
        $this->tanggal = now()->toDateString();
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Absensi::query()
                    ->with(['karyawan.team.departemen'])
                    ->when($this->tanggal, fn (Builder $query) => $query->whereDate('tanggal', $this->tanggal))
                    ->orderByDesc('tanggal')
            )
            ->columns([
                TextColumn::make('tanggal')
                    ->label('Tanggal')
                    ->date()
                    ->sortable(),

                TextColumn::make('karyawan.nama_karyawan')
                    ->label('Karyawan')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('karyawan.team.nama_team')
                    ->label('Team')
                    ->sortable(),

                TextColumn::make('karyawan.team.departemen.nama_departemen')
                    ->label('Departemen')
                    ->sortable(),

                TextColumn::make('waktu_masuk')
                    ->label('Masuk')
                    ->dateTime('H:i')
                    ->sortable(),

                TextColumn::make('waktu_pulang')
                    ->label('Pulang')
                    ->dateTime('H:i')
                    ->sortable(),

                BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'success' => 'Hadir',
                        'warning' => 'Izin',
                        'info' => 'Sakit',
                        'danger' => 'Alpha',
                    ]),

                TextColumn::make('lembur_jam')
                    ->label('Lembur')
                    ->suffix(' jam')
                    ->sortable(),
            ]);
    }
}
