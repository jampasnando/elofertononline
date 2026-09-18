<?php

namespace App\Filament\Especial\Resources\Ventas\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class VentasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('fecha')
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('cliente')
                    ->searchable()
                    ->sortable()
                    ->label('Cliente'),

                TextColumn::make('total')
                    ->money('BOB')
                    ->sortable(),

                TextColumn::make('formapago')
                    ->label('Forma de pago')
                    ->badge()
                    ->colors([
                        'info' => 'credito',
                        'warning' => 'contado',
                    ]),
            ])
            ->defaultSort('fecha', 'desc')
            ->recordActions([
                // ViewAction::make(),
                // EditAction::make(),
                // Action::make('nota')
                //     ->label('Nota')
                //     ->icon('heroicon-o-document-arrow-down')
                //     ->url(fn ($record) =>
                //         $record
                //             ? route('ventas.nota', ['venta' => $record->id])
                //             : null
                //     )
                //     ->visible(fn ($record) => filled($record))
                    // ->openUrlInNewTab()
            ])
            ->headerActions([
                // ExportAction::make()
                //     ->exporter(InventarioVentaExporter::class),
            ])
            ->defaultSort('fecha', 'desc');

    }
}
