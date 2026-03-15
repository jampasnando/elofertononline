<?php

namespace App\Filament\Resources\Compras\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ComprasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('idneg')
                    ->searchable(),
                TextColumn::make('idcompra')
                    ->searchable(),
                TextColumn::make('total')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('proveedor')
                    ->searchable(),
                TextColumn::make('nit')
                    ->searchable(),
                TextColumn::make('formapago')
                    ->searchable(),
                TextColumn::make('fecha')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('comprador')
                    ->searchable(),
                TextColumn::make('idusr')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('factura')
                    ->searchable(),
            ])
            ->defaultSort('fecha', 'desc')
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make()
                    ->label('detalle'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    // DeleteBulkAction::make(),
                ]),
            ]);
    }
}
