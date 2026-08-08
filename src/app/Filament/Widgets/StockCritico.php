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

    protected static ?string $pollingInterval = null;
    protected static ?int $sort = 5;

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
         * Ventas de cada producto durante los últimos 30 días.
         */
        $ventasPorProducto = DB::table('detalleventas as dv')
            ->join('ventas as v', 'v.idventa', '=', 'dv.idventa')
            ->where('v.fecha', '>=', $fechaInicio)
            ->where('v.fecha', '<', $fechaFin)
            ->select('dv.idprod')
            ->selectRaw('SUM(dv.cuantos) as vendidos')
            ->groupBy('dv.idprod');

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
                    ->select([
                        'inventarios.id',
                        'inventarios.idprod',
                        'inventarios.descripcion',
                        'inventarios.marca',
                        'inventarios.cantidad',
                        'inventarios.unidad',
                    ])
                    ->selectRaw(
                        'COALESCE(vp.vendidos, 0) as vendidos'
                    )

                    /*
                     * Primero los agotados.
                     * Después productos con ventas recientes.
                     * Los que no tienen ventas quedan al final.
                     */
                    ->orderByRaw(
                        'CASE
                            WHEN inventarios.cantidad <= 0 THEN 0
                            WHEN COALESCE(vp.vendidos, 0) > 0 THEN 1
                            ELSE 2
                        END'
                    )

                    /*
                     * Para productos con ventas, priorizamos
                     * los que tienen menor stock respecto a su consumo.
                     */
                    ->orderByRaw(
                        'CASE
                            WHEN COALESCE(vp.vendidos, 0) > 0
                            THEN inventarios.cantidad / (vp.vendidos / 30)
                            ELSE 999999
                        END'
                    )

                    ->limit(10)
            )

            ->columns([

                Tables\Columns\TextColumn::make('descripcion')
                    ->label('Producto')
                    ->wrap(),

                Tables\Columns\TextColumn::make('marca')
                    ->label('Marca'),

                Tables\Columns\TextColumn::make('cantidad')
                    ->label('Stock')
                    ->numeric(decimalPlaces: 2)
                    ->color(function ($state) {
                        return (float) $state <= 0
                            ? 'danger'
                            : 'warning';
                    }),

                Tables\Columns\TextColumn::make('unidad')
                    ->label('Unidad'),

                Tables\Columns\TextColumn::make('vendidos')
                    ->label('Ventas 30 días')
                    ->numeric(decimalPlaces: 2),

                Tables\Columns\TextColumn::make('dias_stock')
                    ->label('Días de stock')
                    ->state(function ($record) {

                        $vendidos = (float) $record->vendidos;
                        $cantidad = (float) $record->cantidad;

                        /*
                         * Si no hubo ventas no podemos
                         * calcular días de stock.
                         */
                        if ($vendidos <= 0) {
                            return null;
                        }

                        /*
                         * Consumo promedio diario.
                         */
                        $consumoDiario = $vendidos / 30;

                        return $cantidad / $consumoDiario;
                    })
                    ->formatStateUsing(function ($state) {

                        if ($state === null) {
                            return 'Sin ventas';
                        }

                        return number_format(
                            (float) $state,
                            1
                        ) . ' días';
                    })
                    ->color(function ($state) {

                        if ($state === null) {
                            return 'gray';
                        }

                        return match (true) {
                            $state <= 7 => 'danger',
                            $state <= 15 => 'warning',
                            default => 'success',
                        };
                    }),

                Tables\Columns\TextColumn::make('estado')
                    ->label('Estado')
                    ->state(function ($record) {

                        $cantidad = (float) $record->cantidad;
                        $vendidos = (float) $record->vendidos;

                        /*
                         * 1. Sin stock.
                         */
                        if ($cantidad <= 0) {
                            return 'AGOTADO';
                        }

                        /*
                         * 2. Tiene stock pero no tuvo
                         * ventas en los últimos 30 días.
                         */
                        if ($vendidos <= 0) {
                            return 'SIN VENTAS';
                        }

                        /*
                         * 3. Calculamos días de stock.
                         */
                        $diasStock = $cantidad / ($vendidos / 30);

                        if ($diasStock <= 7) {
                            return 'REPOSICIÓN URGENTE';
                        }

                        if ($diasStock <= 15) {
                            return 'STOCK BAJO';
                        }

                        return 'NORMAL';
                    })
                    ->badge()
                    ->color(function ($state) {

                        return match ($state) {
                            'AGOTADO' => 'danger',
                            'REPOSICIÓN URGENTE' => 'danger',
                            'STOCK BAJO' => 'warning',
                            'SIN VENTAS' => 'gray',
                            'NORMAL' => 'success',
                            default => 'gray',
                        };
                    }),
            ])

            ->paginated(false);
    }
}
