<?php

namespace App\Filament\Resources\Carritos\Schemas;

use App\Models\Inventario;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Illuminate\Support\Facades\Log;

class CarritoInfolist
{
    public static function configure(Schema $schema, $record = null): Schema
    {
        $inventarios = collect(); // 👈 SIEMPRE inicializa

        if ($record && $record->productos) {

            $productosIds = collect($record->productos)
                ->pluck('id')
                ->filter()
                ->toArray();

            $inventarios = Inventario::whereIn('id', $productosIds)
                ->pluck('stock', 'id');
        }
        return $schema
            ->schema([
                TextEntry::make('created_at')
                    ->dateTime()
                    ->label('Fecha'),
                TextEntry::make('id')
                    ->label('Pedido Nº')
                    ->weight('bold'),

                TextEntry::make('estado')
                    ->badge()
                    ->color(fn (?string $state) => match ($state) {
                        'pendiente' => 'warning',
                        'contactado' => 'info',
                        'cancelado' => 'danger',
                        'confirmado' => 'success',
                        default => 'gray',
                    }),

                RepeatableEntry::make('productos')
                    ->label('Productos')
                    ->schema([
                        ImageEntry::make('img')
                            ->imageHeight(60)
                            ->circular(),

                        TextEntry::make('nombre')
                            ->weight('bold')
                            ->color(function ($state, $item) use ($inventarios) {

                                $stock = $inventarios[$item['id'] ?? null] ?? 0;

                                return $stock < $state ? 'danger' : null;
                            })
                            ->tooltip(function ($state, $item) use ($inventarios) {

                                $stock = $inventarios[$item['id'] ?? null] ?? 0;

                                return "Stock actual: {$stock}";
                            })
                            ->columnSpan(2),

                        TextEntry::make('cantidad')
                            ->label('Cant.')
                            ->color(function ($state, $item) use ($inventarios) {

                                $stock = $inventarios[$item['id'] ?? null] ?? 0;

                                return $stock < $state ? 'danger' : null;
                            })
                            ->tooltip(function ($state, $item) use ($inventarios) {

                                $stock = $inventarios[$item['id'] ?? null] ?? 0;

                                return "Stock actual: {$stock}";
                            }),

                        TextEntry::make('precio')
                            ->label('Precio')
                            // ->money('BOB'),
                    ])
                    ->columns(5),


                TextEntry::make('resumen_productos')
                    ->label('Resumen')
                    ->weight('extrabold')
                    ->alignEnd()
                    ->size('lg')
                    ->badge()
                    ->color('success')
                    ->columnSpanFull(),
                TextEntry::make('comentarios')
                    ->label('Comentarios')
                    ->placeholder('-')
                    ->columnSpanFull(),
                    ],
        );
    }
}
