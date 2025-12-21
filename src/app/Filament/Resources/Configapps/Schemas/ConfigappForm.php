<?php

namespace App\Filament\Resources\Configapps\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ConfigappForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('whatsapp')
                    ->required(),
                TextInput::make('nrocuenta')
                    ->required(),
                TextInput::make('banco')
                    ->required(),
                TextInput::make('titularcuenta')
                    ->required(),
                TextInput::make('facebook'),
                TextInput::make('tiktok'),
                TextInput::make('latitud')
                    ->numeric(),
                TextInput::make('longitud')
                    ->numeric(),
            ]);
    }
}
