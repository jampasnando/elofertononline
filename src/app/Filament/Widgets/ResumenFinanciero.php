<?php

namespace App\Filament\Widgets;

use App\Models\Venta;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class ResumenFinanciero extends StatsOverviewWidget
{
    protected static ?int $sort = 3;
    protected  ?string $pollingInterval = null;
    protected function getStats(): array
    {
        $inicioMes = now()->startOfMonth();
        $inicioMesSiguiente = now()
            ->addMonth()
            ->startOfMonth();

        /*
         * ============================================================
         * VENTAS DEL MES
         * ============================================================
         */
        $ventasMes = Venta::where("fecha", ">=", $inicioMes)
            ->where("fecha", "<", $inicioMesSiguiente)
            ->sum("total");

        /*
         * ============================================================
         * COBRADO DEL MES
         * ============================================================
         */
        $cobradoMes = Venta::where("fecha", ">=", $inicioMes)
            ->where("fecha", "<", $inicioMesSiguiente)
            ->sum("pago");

        /*
         * ============================================================
         * SALDO POR COBRAR
         *
         * Aquí mostramos el saldo pendiente de TODAS las ventas,
         * no solamente las ventas del mes actual.
         * ============================================================
         */
        $porCobrar = Venta::where("saldo", ">", 0)->sum("saldo");

        /*
         * ============================================================
         * UTILIDAD DEL MES
         *
         * preciofinal = precio realmente vendido
         * preciolocal = costo histórico
         * cuantos     = cantidad vendida
         *
         * Utilidad = (preciofinal - preciolocal) * cuantos
         * ============================================================
         */
        $utilidadMes = DB::table("detalleventas as dv")
            ->join("ventas as v", "v.idventa", "=", "dv.idventa")
            ->where("v.fecha", ">=", $inicioMes)
            ->where("v.fecha", "<", $inicioMesSiguiente)
            ->selectRaw(
                "COALESCE(SUM((dv.preciofinal - dv.preciolocal) * dv.cuantos), 0) as utilidad"
            )
            ->value("utilidad");

        /*
         * ============================================================
         * MARGEN
         * ============================================================
         */
        $facturacionDetalle = DB::table("detalleventas as dv")
            ->join("ventas as v", "v.idventa", "=", "dv.idventa")
            ->where("v.fecha", ">=", $inicioMes)
            ->where("v.fecha", "<", $inicioMesSiguiente)
            ->selectRaw(
                "COALESCE(SUM(dv.preciofinal * dv.cuantos), 0) as total"
            )
            ->value("total");

        $margen =
            $facturacionDetalle > 0
                ? ($utilidadMes / $facturacionDetalle) * 100
                : 0;

        return [
            Stat::make("Ventas del mes", "Bs. " . number_format($ventasMes, 2))
                ->description("Facturación del mes actual")
                ->descriptionIcon("heroicon-m-banknotes")
                ->color("primary"),

            Stat::make("Cobrado", "Bs. " . number_format($cobradoMes, 2))
                ->description("Pagos recibidos este mes")
                ->descriptionIcon("heroicon-m-currency-dollar")
                ->color("success"),

            Stat::make("Por cobrar", "Bs. " . number_format($porCobrar, 2))
                ->description("Saldo pendiente de clientes")
                ->descriptionIcon("heroicon-m-credit-card")
                ->color($porCobrar > 0 ? "warning" : "success"),

            Stat::make("Utilidad", "Bs. " . number_format($utilidadMes, 2))
                ->description("Margen: " . number_format($margen, 1) . "%")
                ->descriptionIcon("heroicon-m-chart-bar")
                ->color($utilidadMes >= 0 ? "success" : "danger"),
        ];
    }
}
