<?php

namespace App\Filament\Resources\Detallecompras;

use App\Filament\Resources\Detallecompras\Pages\CreateDetallecompra;
use App\Filament\Resources\Detallecompras\Pages\EditDetallecompra;
use App\Filament\Resources\Detallecompras\Pages\ListDetallecompras;
use App\Filament\Resources\Detallecompras\Schemas\DetallecompraForm;
use App\Filament\Resources\Detallecompras\Tables\DetallecomprasTable;
use App\Models\Detallecompra;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DetallecompraResource extends Resource
{
    protected static ?string $model = Detallecompra::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return DetallecompraForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DetallecomprasTable::configure($table);
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
            'index' => ListDetallecompras::route('/'),
            'create' => CreateDetallecompra::route('/create'),
            'edit' => EditDetallecompra::route('/{record}/edit'),
        ];
    }
}
