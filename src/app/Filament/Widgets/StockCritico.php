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

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        $fechaInicio = now()
            ->subDays(29)
            ->startOfDay();

        $fechaFin = now()
            ->addDay()
            ->startOfDay();

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
                    ->where('inventarios.cantidad', '<=', 5)
                    ->select([
                        'inventarios.id',
                        'inventarios.idprod',
                        'inventarios.descripcion',
                        'inventarios.marca',
                        'inventarios.cantidad',
                        'inventarios.unidad',
                    ])
                    ->selectRaw('COALESCE(vp.vendidos, 0) as vendidos')
                    ->selectRaw(
                        'CASE
                            WHEN COALESCE(vp.vendidos, 0) > 0
                            THEN inventarios.cantidad / (vp.vendidos / 30)
                            ELSE NULL
                        END as dias_stock'
                    )
                    ->limit(10)
            )
            ->columns([
                Tables\Columns\TextColumn::make('descripcion')
                    ->label('Producto'),

                Tables\Columns\TextColumn::make('cantidad')
                    ->label('Stock'),

                Tables\Columns\TextColumn::make('marca')
                    ->label('Marca'),

                Tables\Columns\TextColumn::make('vendidos')
                    ->label('Vendidos 30 días'),

                Tables\Columns\TextColumn::make('dias_stock')
                    ->label('Días de stock')
                    ->numeric(decimalPlaces: 1)
                    ->suffix(' días'),
            ])
            ->paginated(false);
    }
}
