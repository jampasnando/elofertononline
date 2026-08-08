<?php

namespace App\Filament\Widgets;

use App\Models\Inventario;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\DB;

class StockCritico extends BaseWidget
{
    protected static ?string $heading = 'Stock crítico';
    protected static ?int $sort = 5;

    protected static ?string $pollingInterval = null;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        $fechaInicio = now()
            ->subDays(29)
            ->startOfDay();

        $fechaFin = now()
            ->addDay()
            ->startOfDay();

        /*
         * Primero calculamos cuánto se vendió de cada producto
         * durante los últimos 30 días.
         */
        $ventasPorProducto = DB::table('detalleventas as dv')
            ->join('ventas as v', 'v.idventa', '=', 'dv.idventa')
            ->where('v.fecha', '>=', $fechaInicio)
            ->where('v.fecha', '<', $fechaFin)
            ->select('dv.idprod')
            ->selectRaw('SUM(dv.cuantos) as vendidos')
            ->groupBy('dv.idprod');

        /*
         * Después unimos ese pequeño resultado con inventarios.
         *
         * Importante:
         * primero filtramos productos con stock <= 5.
         */
        return $table
            ->query(
                Inventario::query()
                    ->leftJoinSub(
                        $ventasPorProducto,
                        'vp',
                        'vp.idprod',
                        '=',
                        'inventarios.id'
                    )
                    ->where('inventarios.cantidad', '<=', 5)
                    ->select([
                        'inventarios.id',
                        'inventarios.idprod',
                        'inventarios.descripcion',
                        'inventarios.marca',
                        'inventarios.cantidad',
                        'inventarios.unidad',
                        'inventarios.precioventa',
                    ])
                    ->selectRaw(
                        'COALESCE(vp.vendidos, 0) as vendidos'
                    )
                    ->selectRaw(
                        'CASE
                            WHEN COALESCE(vp.vendidos, 0) > 0
                            THEN inventarios.cantidad / (vp.vendidos / 30)
                            ELSE NULL
                        END as dias_stock'
                    )
                    ->orderByRaw(
                        'CASE
                            WHEN inventarios.cantidad <= 0 THEN 0
                            ELSE 1
                        END'
                    )
                    ->orderByRaw(
                        'CASE
                            WHEN vp.vendidos > 0
                            THEN inventarios.cantidad / (vp.vendidos / 30)
                            ELSE 999999
                        END'
                    )
            )
            ->columns([
                Tables\Columns\TextColumn::make('descripcion')
                    ->label('Producto')
                    ->searchable()
                    ->wrap(),

                Tables\Columns\TextColumn::make('marca')
                    ->label('Marca')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('cantidad')
                    ->label('Stock')
                    ->numeric(decimalPlaces: 2)
                    ->sortable()
                    ->color(fn ($state) => match (true) {
                        $state <= 0 => 'danger',
                        $state <= 2 => 'danger',
                        default => 'warning',
                    }),

                Tables\Columns\TextColumn::make('unidad')
                    ->label('Unidad'),

                Tables\Columns\TextColumn::make('vendidos')
                    ->label('Vendidos 30 días')
                    ->numeric(decimalPlaces: 2)
                    ->sortable(),

                Tables\Columns\TextColumn::make('dias_stock')
                    ->label('Días de stock')
                    ->numeric(decimalPlaces: 1)
                    ->suffix(' días')
                    ->sortable()
                    ->placeholder('Sin ventas')
                    ->color(fn ($state) => match (true) {
                        $state === null => 'gray',
                        $state <= 3 => 'danger',
                        $state <= 7 => 'warning',
                        default => 'success',
                    }),

                Tables\Columns\TextColumn::make('estado')
                    ->label('Estado')
                    ->state(function ($record) {
                        if ($record->cantidad <= 0) {
                            return 'AGOTADO';
                        }

                        if (
                            $record->dias_stock !== null &&
                            $record->dias_stock <= 7
                        ) {
                            return 'REPOSICIÓN URGENTE';
                        }

                        return 'STOCK BAJO';
                    })
                    ->badge()
                    ->color(function ($state) {
                        return match ($state) {
                            'AGOTADO' => 'danger',
                            'REPOSICIÓN URGENTE' => 'warning',
                            default => 'gray',
                        };
                    }),
            ])
            ->defaultSort('dias_stock', 'asc')
            ->paginated([10]);
    }
}
