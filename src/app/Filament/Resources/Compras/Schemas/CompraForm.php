<?php

namespace App\Filament\Resources\Compras\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class CompraForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // TextInput::make('idneg')
                //     ->required(),
                TextInput::make('idcompra')
                    ->required(),
                // TextInput::make('total')
                //     ->required()
                //     ->numeric(),
                // TextInput::make('proveedor'),
                // TextInput::make('nit'),
                // TextInput::make('formapago'),
                DateTimePicker::make('fecha')
                    ->required(),
                // Textarea::make('comentario')
                //     ->columnSpanFull(),
                // TextInput::make('comprador'),
                // TextInput::make('idusr')
                //     ->required()
                //     ->numeric(),
                // TextInput::make('factura'),
            ])
            ->columns(4);
    }
}
