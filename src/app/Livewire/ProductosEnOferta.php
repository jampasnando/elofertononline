<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\Oferta;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Filament\Resources\Ofertas\OfertaResource;

class ProductosEnOferta extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $hoy = Carbon::today();

        $cantidad = Oferta::whereDate('fecha_inicio', '<=', $hoy)
            ->whereDate('fecha_fin', '>=', $hoy)
            ->distinct('inventario_id') // 👈 evita duplicados
            ->count('inventario_id');

        return [
            Stat::make('Productos en oferta', $cantidad)
                ->description('Ofertas activas hoy')
                ->color('success')
                ->icon('heroicon-o-tag')
                ->url(OfertaResource::getUrl('index')) // 👈 AQUÍ
                ->openUrlInNewTab(false),
        ];
    }
}
