<?php

namespace App\Livewire;

use App\Models\Inventario;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Filament\Resources\Inventarios\InventarioResource;

class ProductosSinStock extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $cantidad = Inventario::where('cantidad', 0)->count();

        return [
            Stat::make('Productos sin stock', $cantidad)
                ->description('Cantidad actual en 0')
                ->color('danger')
                ->icon('heroicon-o-exclamation-triangle')
                ->url(
                    InventarioResource::getUrl('index', [
                        'tableFilters[sin_stock][value]' => 1,
                    ])
                ),
        ];
    }
}
