<?php

namespace App\Filament\Resources\Absensis\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AbsensiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('karyawan_id')
                    ->label('Karyawan')
                    ->relationship('karyawan', 'nama_karyawan')
                    ->searchable()
                    ->preload()
                    ->required(),

                DatePicker::make('tanggal')
                    ->label('Tanggal')
                    ->required()
                    ->default(now()),

                DateTimePicker::make('waktu_masuk')
                    ->label('Waktu Masuk')
                    ->native(false),

                DateTimePicker::make('waktu_pulang')
                    ->label('Waktu Pulang')
                    ->native(false),

                Select::make('status')
                    ->label('Status')
                    ->options([
                        'Hadir' => 'Hadir',
                        'Izin' => 'Izin',
                        'Sakit' => 'Sakit',
                        'Alpha' => 'Alpha',
                    ])
                    ->default('Hadir')
                    ->required(),

                TextInput::make('lembur_jam')
                    ->label('Lembur (jam)')
                    ->numeric()
                    ->default(0)
                    ->minValue(0)
                    ->maxValue(24),

                TextInput::make('keterangan_lembur')
                    ->label('Keterangan Lembur')
                    ->placeholder('Contoh: proyek deadline, maintenance server'),

                FileUpload::make('foto_masuk')
                    ->label('Foto Masuk')
                    ->image()
                    ->directory('absensi'),

                FileUpload::make('foto_pulang')
                    ->label('Foto Pulang')
                    ->image()
                    ->directory('absensi'),
            ])->columns(2);
    }
}
