<?php

namespace App\Filament\Resources\Detallecompras\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DetallecomprasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('idcompra')
                    ->searchable(),
                TextColumn::make('idprod')
                    ->searchable(),
                TextColumn::make('preciolocal')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('cuantos')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('registrado')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
