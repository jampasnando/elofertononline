<?php

namespace App\Filament\Resources\Inventarios\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\CreateAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class InventariosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                
                TextColumn::make('id')
                    ->label('ID')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('idprod')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('descripcion')
                    ->label('Descripción')
                    ->limit(30)
                    ->searchable()
                    ->tooltip(fn ($record) => $record->descripcion),
                TextColumn::make('marca')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('cantidad')
                    ->numeric()
                    ->sortable()
                    ->label('Cant'),
                TextColumn::make('categoria')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('unidad')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('preciolocal')
                    ->numeric()
                    ->visible(fn () => auth()->user()->role === 'administrador')
                    ->sortable()
                    ->label('PComp'),
                TextColumn::make('precioventa')
                    ->numeric()
                    ->sortable()
                    ->label('PVenta'),
                TextColumn::make('comision')
                    ->numeric()
                    ->visible(fn () => auth()->user()->role === 'administrador')
                    ->sortable(),
                TextColumn::make('deposito')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('proveedor')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('img1')
                    ->limit(10)
                    ->sortable()
                    ->tooltip(fn ($record) => $record->img1),
                TextColumn::make('img2')
                    ->limit(10)
                    ->tooltip(fn ($record) => $record->img2),
                TextColumn::make('img3')
                    ->limit(10)
                    ->tooltip(fn ($record) => $record->img3),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                    ->disabled(fn () => auth()->user()->role !== 'administrador'),
                ]),
                
            ]);
            
    }
}
