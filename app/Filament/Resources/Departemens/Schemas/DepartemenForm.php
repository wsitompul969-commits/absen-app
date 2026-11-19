<?php

namespace App\Filament\Resources\Departemens\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class DepartemenForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama_departemen')
                    ->label('Nama Departemen')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
            ]);
    }
}
