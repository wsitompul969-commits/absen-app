<?php

namespace App\Filament\Resources\Karyawans;

use App\Filament\Resources\Karyawans\Pages\CreateKaryawan;
use App\Filament\Resources\Karyawans\Pages\EditKaryawan;
use App\Filament\Resources\Karyawans\Pages\ListKaryawans;
use App\Filament\Resources\Karyawans\Schemas\KaryawanForm;
use App\Filament\Resources\Karyawans\Tables\KaryawansTable;
use App\Models\Karyawan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class KaryawanResource extends Resource
{
    protected static ?string $model = Karyawan::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string|UnitEnum|null $navigationGroup = 'Master Data';

    protected static ?string $navigationLabel = 'Karyawan';

    protected static ?int $navigationSort = 3;

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $user = auth()->user();

        if ($user?->isEmployee()) {
            $query->where('user_id', $user->getKey());
        }

        return $query;
    }

    public static function form(Schema $schema): Schema
    {
        return KaryawanForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return KaryawansTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListKaryawans::route('/'),
            'create' => CreateKaryawan::route('/create'),
            'edit' => EditKaryawan::route('/{record}/edit'),
        ];
    }
}
