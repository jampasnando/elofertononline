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
            ])
            ->paginated(false);
    }
}
