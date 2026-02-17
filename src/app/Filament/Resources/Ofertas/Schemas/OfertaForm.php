<?php

namespace App\Filament\Resources\Ofertas\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class OfertaForm
{
    public static function configure(Schema $schema): Schema
    {
        $unaoferta = $schema->getRecord();
        return $schema
            ->components([
                TextInput::make('inventario_id')
                    ->required()
                    ->hidden(true),
                TextEntry::make('inventario.idprod')
                    ->label('ID de producto')
                    ->hidden(fn () => $unaoferta === null),
                TextEntry::make('inventario.descripcion')
                    ->label('Descripción del producto')
                    ->hidden(fn () => $unaoferta === null),
                TextInput::make('precio_oferta')
                    ->required()
                    ->numeric(),
                DatePicker::make('fecha_inicio')
                    ->required(),
                DatePicker::make('fecha_fin')
                    ->required(),
                Toggle::make('activo'),
            ])
            ->columns(3);
    }
}
