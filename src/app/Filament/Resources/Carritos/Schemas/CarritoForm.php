<?php

namespace App\Filament\Resources\Carritos\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class CarritoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('productos'),
                Select::make('estado')
                ->options([
                    'pendiente' => 'Pendiente',
                    'contactado' => 'Contactado',
                    'confirmado' => 'Confirmado',
                    'cancelado' => 'Cancelado',
                ])
                ->default('pendiente')
                ->required(),
                Textarea::make('comentario')
                    ->columnSpanFull(),
            ]);
    }
}
