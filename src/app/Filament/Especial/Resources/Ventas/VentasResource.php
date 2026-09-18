<?php

namespace App\Filament\Especial\Resources\Ventas;

use App\Filament\Especial\Resources\Ventas\Pages\CreateVentas;
use App\Filament\Especial\Resources\Ventas\Pages\EditVentas;
use App\Filament\Especial\Resources\Ventas\Pages\ListVentas;
use App\Filament\Especial\Resources\Ventas\Schemas\VentasForm;
use App\Filament\Especial\Resources\Ventas\Tables\VentasTable;
use App\Models\Venta;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class VentasResource extends Resource
{
    protected static ?string $model = Venta::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'idventa';

    public static function form(Schema $schema): Schema
    {
        return VentasForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return VentasTable::configure($table);
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
            'index' => ListVentas::route('/'),
            // 'create' => CreateVentas::route('/create'),
            // 'edit' => EditVentas::route('/{record}/edit'),
        ];
    }
}
