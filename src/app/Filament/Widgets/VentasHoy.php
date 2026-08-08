<?php

namespace App\Filament\Widgets;

use App\Models\Venta;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class VentasHoy extends StatsOverviewWidget
{
    protected static ?int $sort = 1;
    protected function getStats(): array
    {
        $hoy = now()->startOfDay();
        $manana = now()
            ->addDay()
            ->startOfDay();

        $ayer = now()
            ->subDay()
            ->startOfDay();

        // Ventas de hoy
        $ventasHoy = Venta::where("fecha", ">=", $hoy)
            ->where("fecha", "<", $manana)
            ->sum("total");

        // Ventas de ayer
        $ventasAyer = Venta::where("fecha", ">=", $ayer)
            ->where("fecha", "<", $hoy)
            ->sum("total");

        // Cantidad de operaciones de hoy
        $cantidadHoy = Venta::where("fecha", ">=", $hoy)
            ->where("fecha", "<", $manana)
            ->count();

        // Variación porcentual respecto a ayer
        if ($ventasAyer > 0) {
            $variacion = (($ventasHoy - $ventasAyer) / $ventasAyer) * 100;
        } else {
            $variacion = $ventasHoy > 0 ? 100 : 0;
        }

        $variacionTexto = number_format(abs($variacion), 1) . "%";

        return [
            Stat::make("Ventas de hoy", "Bs. " . number_format($ventasHoy, 2))
                ->description(
                    ($variacion >= 0 ? "↑ " : "↓ ") .
                        $variacionTexto .
                        " respecto a ayer"
                )
                ->descriptionIcon(
                    $variacion >= 0
                        ? "heroicon-m-arrow-trending-up"
                        : "heroicon-m-arrow-trending-down"
                )
                ->color($variacion >= 0 ? "success" : "danger"),

            Stat::make("Operaciones de hoy", number_format($cantidadHoy))
                ->description("Ventas realizadas hoy")
                ->descriptionIcon("heroicon-m-shopping-cart")
                ->color("primary"),
        ];
    }
}
