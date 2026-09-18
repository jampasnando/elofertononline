<?php

namespace App\Filament\Especial\Resources\Comisiones\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ComisionesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('vendedor.nombre')
                    ->searchable()
                    ->label('Vendedor')
                    ->sortable(),
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
                TextColumn::make('preciofinal')
                    ->money('BOB')
                    ->sortable(),
                TextColumn::make('comision')
                    ->money('BOB')
                    ->summarize(Sum::make()->money('BOB'))
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('vendedor')
                    ->relationship('vendedor', 'nombre')
                    ->label('Vendedor'),
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
