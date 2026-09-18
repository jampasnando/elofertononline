<?php

namespace App\Filament\Especial\Resources\Detalleventas;

use App\Filament\Especial\Resources\Detalleventas\Pages\CreateDetalleventas;
use App\Filament\Especial\Resources\Detalleventas\Pages\EditDetalleventas;
use App\Filament\Especial\Resources\Detalleventas\Pages\ListDetalleventas;
use App\Filament\Especial\Resources\Detalleventas\Schemas\DetalleventasForm;
use App\Filament\Especial\Resources\Detalleventas\Tables\DetalleventasTable;
use App\Models\Detalleventa;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DetalleventasResource extends Resource
{
    protected static ?string $model = Detalleventa::class;
    protected static ?string $navigationLabel = 'Comisiones';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'idventa';

    public static function form(Schema $schema): Schema
    {
        return DetalleventasForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DetalleventasTable::configure($table);
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
            'index' => ListDetalleventas::route('/'),
            // 'create' => CreateDetalleventas::route('/create'),
            // 'edit' => EditDetalleventas::route('/{record}/edit'),
        ];
    }
}
