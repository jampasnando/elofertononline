<?php

namespace App\Filament\Resources\Inventarios\Pages;

use App\Models\Inventario;
use Filament\Actions\CreateAction;
use App\Livewire\ProductosEnOferta;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\Inventarios\InventarioResource;


class ListInventarios extends ListRecords
{
    protected static string $resource = InventarioResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
    // public function getTabs(): array
    // {
    //     return [

    //         'Todo' => Tab::make()
    //             ->modifyQueryUsing(fn (Builder $query) => $query->where('estado', 'activo'))
    //             ->badge(Inventario::query()->where('estado', 'activo')->count()),
    //         'Inactivos' => Tab::make()
    //             ->modifyQueryUsing(fn (Builder $query) => $query->where('estado', 'inactivo'))
    //             ->badge(Inventario::query()->where('estado', 'inactivo')->count())
    //     ];
    // }
    protected function getHeaderWidgets(): array
    {
        return [
            ProductosEnOferta::class,
        ];
    }
}
