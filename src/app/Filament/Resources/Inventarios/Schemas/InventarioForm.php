<?php

namespace App\Filament\Resources\Inventarios\Schemas;

use App\Models\Categoria;
use App\Models\Marca;
use App\Models\Proveedor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class InventarioForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('id')
                    ->label('ID')
                    ->numeric()
                    ->visible(fn()=>auth()->user()->role == 'administrador')
                    ->disabled(),
                TextInput::make('idprod')
                    ->disabled(fn () => auth()->user()->role !== 'administrador')
                    ->visible(fn()=>auth()->user()->role == 'administrador'),
                Textarea::make('descripcion')
                    ->disabled(fn () => auth()->user()->role !== 'administrador')
                    ->visible(fn()=>auth()->user()->role == 'administrador'),
                    // ->columnSpanFull(),
                Select::make('marca')
                    ->options(fn () => Marca::pluck('nombre', 'nombre'))
                    ->disabled(fn () => auth()->user()->role !== 'administrador')
                    ->visible(fn()=>auth()->user()->role == 'administrador'),
                TextInput::make('cantidad')
                    ->disabled(fn () => auth()->user()->role !== 'administrador')
                    ->numeric()
                    ->default(0)
                    ->visible(fn()=>auth()->user()->role == 'administrador'),
                Select::make('categoria')
                    ->disabled(fn () => auth()->user()->role !== 'administrador')
                    ->visible(fn()=>auth()->user()->role == 'administrador')
                    ->options(fn () => Categoria::pluck('nombre', 'nombre')),
                TextInput::make('unidad')
                    ->disabled(fn () => auth()->user()->role !== 'administrador')
                    ->visible(fn()=>auth()->user()->role == 'administrador'),
                TextInput::make('preciolocal')
                    ->numeric()
                    ->visible(fn () => auth()->user()->role === 'administrador')
                    ->visible(fn()=>auth()->user()->role == 'administrador')
                    ->default(0),
                TextInput::make('precioventa')
                    ->numeric()
                    ->disabled(fn () => auth()->user()->role !== 'administrador')
                    ->visible(fn()=>auth()->user()->role == 'administrador')
                    ->default(0),
                TextInput::make('comision')
                    ->numeric()
                    ->visible(fn () => auth()->user()->role === 'administrador')
                    ->visible(fn()=>auth()->user()->role == 'administrador')
                    ->default(0),
                TextInput::make('deposito')
                    ->disabled(fn () => auth()->user()->role !== 'administrador')
                    ->visible(fn()=>auth()->user()->role == 'administrador')
                    ->readOnly()
                    ->default(1),
                Select::make('proveedor')
                    ->options(fn () => Proveedor::pluck('nombre', 'nombre'))
                    ->disabled(fn () => auth()->user()->role !== 'administrador')
                    ->visible(fn()=>auth()->user()->role == 'administrador'),
                Textarea::make('imagenes')
                    ->columnSpanFull()
                    ->disabled(fn () => auth()->user()->role !== 'administrador')
                    ->visible(fn()=>auth()->user()->role == 'administrador'),
                FileUpload::make('img1')
                    ->image()
                    ->disk('public')
                    ->directory('imagenes1')
                    ->downloadable()
                    ->visibility('public')
                    ->previewable()
                    ->imageEditor()
                    ->openable(),
                FileUpload::make('img2')
                    ->image()
                    ->disk('public')
                    ->directory('imagenes2')
                    ->downloadable()
                    ->visibility('public')
                    ->previewable()
                    ->imageEditor()
                    ->openable(),
                FileUpload::make('img3')
                    ->image()
                    ->disk('public')
                    ->directory('imagenes3')
                    ->downloadable()
                    ->visibility('public')
                    ->previewable()
                    ->imageEditor()
                    ->openable(),
            ])
            ->columns(3);
    }
}
