<?php

namespace App\Filament\Resources\Absensis\Pages;

use App\Filament\Exports\AbsensiExporter;
use App\Filament\Resources\Absensis\AbsensiResource;
use Filament\Actions\CreateAction;
use Filament\Actions\ExportAction;
use Filament\Resources\Pages\ListRecords;

class ListAbsensis extends ListRecords
{
    protected static string $resource = AbsensiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ExportAction::make()
                ->exporter(AbsensiExporter::class)
                ->label('Export'),
            CreateAction::make(),
        ];
    }
}
