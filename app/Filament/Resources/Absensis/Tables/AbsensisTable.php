<?php

namespace App\Filament\Resources\Absensis\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AbsensisTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('karyawan.nama_karyawan')
                    ->label('Karyawan')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('karyawan.team.nama_team')
                    ->label('Team')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('tanggal')
                    ->label('Tanggal')
                    ->date()
                    ->sortable(),

                BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'success' => 'Hadir',
                        'warning' => 'Izin',
                        'danger' => 'Alpha',
                        'info' => 'Sakit',
                    ]),

                TextColumn::make('jam_lembur')
                    ->label('Lembur')
                    ->suffix(' jam')
                    ->sortable(),

                TextColumn::make('keterangan_lembur')
                    ->label('Keterangan')
                    ->wrap(),

                TextColumn::make('waktu_masuk')
                    ->label('Masuk')
                    ->dateTime(),

                TextColumn::make('waktu_pulang')
                    ->label('Pulang')
                    ->dateTime(),

                ImageColumn::make('foto_masuk')
                    ->label('Foto Masuk')
                    ->disk('public'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
