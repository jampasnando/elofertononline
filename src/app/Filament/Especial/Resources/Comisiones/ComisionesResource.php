<?php

namespace App\Filament\Especial\Resources\Comisiones;

use App\Filament\Especial\Resources\Comisiones\Pages\CreateComisiones;
use App\Filament\Especial\Resources\Comisiones\Pages\EditComisiones;
use App\Filament\Especial\Resources\Comisiones\Pages\ListComisiones;
use App\Filament\Especial\Resources\Comisiones\Schemas\ComisionesForm;
use App\Filament\Especial\Resources\Comisiones\Tables\ComisionesTable;
use App\Models\Comisiones;
use App\Models\Detalleventa;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ComisionesResource extends Resource
{
    protected static ?string $model = Detalleventa::class;
    protected static ?string $navigationLabel = 'Comisiones';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static ?string $pluralModelLabel = 'Comisiones';

    protected static ?string $recordTitleAttribute = 'vendedor';

    public static function form(Schema $schema): Schema
    {
        return ComisionesForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ComisionesTable::configure($table);
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
            'index' => ListComisiones::route('/'),
            // 'create' => CreateComisiones::route('/create'),
            // 'edit' => EditComisiones::route('/{record}/edit'),
        ];
    }
}
