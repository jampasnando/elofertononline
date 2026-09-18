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
    protected static ?string $pluralModelLabel = 'Comisiones';
    protected static ?string $slug = 'comisiones';
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('vendedorRelacion.nombre')
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
                    ->summarize([
                        Sum::make()
                            ->label('Sin pago')
                            ->money('BOB')
                            ->query(fn ($query) => $query->whereNull('pagocomision')),
                        Sum::make()
                            ->label('Pagadas')
                            ->money('BOB')
                            ->query(fn ($query) => $query->whereNotNull('pagocomision')),
                    ])
                    ->sortable(),
                TextColumn::make('pagocomision')
                    ->date('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('vendedorRelacion')
                    ->relationship('vendedorRelacion', 'nombre')
                    ->label('Vendedor'),
            ])
            ->recordActions([
                // EditAction::make(),
            ])
            ->toolbarActions([
                // BulkActionGroup::make([
                //     DeleteBulkAction::make(),
                // ]),
            ]);
    }
}
