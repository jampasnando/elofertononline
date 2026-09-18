<?php

namespace App\Filament\Especial\Resources\Detalleventas\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DetalleventasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('idventa')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('idprod')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('descripcion')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('cuantos')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('precioventa')
                    ->money('BOB')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                // EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    // DeleteBulkAction::make(),
                ]),
            ]);
    }
}
