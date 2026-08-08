<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\DB;

class ProductosMasVendidos extends BaseWidget
{
    protected static ?string $heading = "Productos más vendidos - últimos 30 días";

    protected static ?string $pollingInterval = null;

    protected int|string|array $columnSpan = "full";

    public function table(Table $table): Table
    {
        return $table
            ->query(
                fn() => DB::table("detalleventas as dv")
                    ->join("ventas as v", "v.idventa", "=", "dv.idventa")
                    ->join("inventarios as i", "i.id", "=", "dv.idprod")
                    ->where(
                        "v.fecha",
                        ">=",
                        now()
                            ->subDays(29)
                            ->startOfDay()
                    )
                    ->where(
                        "v.fecha",
                        "<",
                        now()
                            ->addDay()
                            ->startOfDay()
                    )
                    ->select([
                        "i.id",
                        "i.idprod",
                        "i.descripcion",
                        "i.marca",
                        "i.unidad",
                    ])
                    ->selectRaw("SUM(dv.cuantos) as unidades")
                    ->selectRaw(
                        "SUM(dv.preciofinal * dv.cuantos) as facturacion"
                    )
                    ->selectRaw(
                        "SUM((dv.preciofinal - dv.preciolocal) * dv.cuantos) as utilidad"
                    )
                    ->groupBy(
                        "i.id",
                        "i.idprod",
                        "i.descripcion",
                        "i.marca",
                        "i.unidad"
                    )
                    ->orderByDesc("unidades")
            )
            ->columns([
                Tables\Columns\TextColumn::make("descripcion")
                    ->label("Producto")
                    ->searchable()
                    ->wrap(),

                Tables\Columns\TextColumn::make("marca")
                    ->label("Marca")
                    ->toggleable(),

                Tables\Columns\TextColumn::make("unidad")
                    ->label("Unidad")
                    ->toggleable(),

                Tables\Columns\TextColumn::make("unidades")
                    ->label("Unidades vendidas")
                    ->numeric(decimalPlaces: 2)
                    ->sortable(),

                Tables\Columns\TextColumn::make("facturacion")
                    ->label("Facturación")
                    ->money("BOB")
                    ->sortable(),

                Tables\Columns\TextColumn::make("utilidad")
                    ->label("Utilidad")
                    ->money("BOB")
                    ->sortable()
                    ->color(fn($state) => $state >= 0 ? "success" : "danger"),
            ])
            ->defaultSort("unidades", "desc")
            ->paginated([10]);
    }
}
