<?php

namespace App\Filament\Resources\Karyawans\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class KaryawanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('team_id')
                    ->label('Team')
                    ->relationship('team', 'nama_team')
                    ->searchable()
                    ->preload()
                    ->required(),

                TextInput::make('nama_karyawan')
                    ->label('Nama Karyawan')
                    ->required()
                    ->maxLength(255),

                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),

                TextInput::make('jabatan')
                    ->label('Jabatan')
                    ->required()
                    ->maxLength(255),
            ]);
    }
}
