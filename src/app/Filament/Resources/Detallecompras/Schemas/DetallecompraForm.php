<?php

namespace App\Filament\Resources\Detallecompras\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class DetallecompraForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('idcompra')
                    ->required(),
                TextInput::make('idprod')
                    ->required(),
                Textarea::make('descripcion')
                    ->columnSpanFull(),
                TextInput::make('preciolocal')
                    ->required()
                    ->numeric(),
                TextInput::make('cuantos')
                    ->required()
                    ->numeric(),
                DateTimePicker::make('registrado'),
            ]);
    }
}
