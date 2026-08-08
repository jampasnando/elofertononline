<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class VentasChart extends ChartWidget
{
    protected ?string $heading = "Ventas y utilidad - últimos 30 días";
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 'full';
    protected function getData(): array
    {
        $inicio = now()
            ->subDays(29)
            ->startOfDay();

        $fin = now()
            ->addDay()
            ->startOfDay();

        /*
         * Obtenemos las ventas agrupadas por día.
         */
        $ventas = DB::table("ventas")
            ->selectRaw("DATE(fecha) as dia, SUM(total) as total")
            ->where("fecha", ">=", $inicio)
            ->where("fecha", "<", $fin)
            ->groupByRaw("DATE(fecha)")
            ->orderBy("dia")
            ->get()
            ->keyBy("dia");

        /*
         * Obtenemos la utilidad agrupando los detalles por día
         * utilizando la fecha de la venta.
         */
        $utilidades = DB::table("detalleventas as dv")
            ->join("ventas as v", "v.idventa", "=", "dv.idventa")
            ->selectRaw(
                'DATE(v.fecha) as dia,
                SUM((dv.preciofinal - dv.preciolocal) * dv.cuantos) as utilidad'
            )
            ->where("v.fecha", ">=", $inicio)
            ->where("v.fecha", "<", $fin)
            ->groupByRaw("DATE(v.fecha)")
            ->orderBy("dia")
            ->get()
            ->keyBy("dia");

        /*
         * Generamos todos los días del período.
         *
         * Esto es importante porque si un día no hubo ventas,
         * queremos mostrar 0 en lugar de desaparecer del gráfico.
         */
        $labels = [];
        $ventasData = [];
        $utilidadData = [];

        for ($i = 0; $i < 30; $i++) {
            $fecha = now()
                ->subDays(29 - $i)
                ->format("Y-m-d");

            $labels[] = now()
                ->subDays(29 - $i)
                ->format("d/m");

            $ventasData[] = round((float) ($ventas[$fecha]->total ?? 0), 2);

            $utilidadData[] = round(
                (float) ($utilidades[$fecha]->utilidad ?? 0),
                2
            );
        }

        return [
            "datasets" => [
                [
                    "label" => "Ventas",
                    "data" => $ventasData,
                    "borderColor" => "#f59e0b",
                    "backgroundColor" => "rgba(245, 158, 11, 0.15)",
                    "fill" => true,
                    "tension" => 0.3,
                ],
                [
                    "label" => "Utilidad",
                    "data" => $utilidadData,
                    "borderColor" => "#10b981",
                    "backgroundColor" => "rgba(16, 185, 129, 0.10)",
                    "fill" => true,
                    "tension" => 0.3,
                ],
            ],
            "labels" => $labels,
        ];
    }

    protected function getType(): string
    {
        return "line";
    }

    protected function getOptions(): array
    {
        return [
            "responsive" => true,
            "maintainAspectRatio" => false,

            "plugins" => [
                "legend" => [
                    "display" => true,
                ],
            ],

            "scales" => [
                "y" => [
                    "beginAtZero" => true,
                ],
            ],
        ];
    }
}
