<?php

namespace App\Filament\Resources\Carritos\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use App\Filament\Resources\Carritos\CarritoResource;
use Illuminate\Database\Eloquent\Builder;

class ListCarritos extends ListRecords
{
    protected static string $resource = CarritoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // CreateAction::make(),
        ];
    }
    public function getCarritosCountByEstado(string $estado): int
    {
        return $this->getResource()::getEloquentQuery()
            ->where('estado', $estado)
            ->count();
    }
    public function getTabs(): array
    {
        return [
            'Pendientes' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('estado', 'pendiente'))
                 ->badge($this->getCarritosCountByEstado('pendiente')),
            'Contactados' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('estado', 'contactado'))
                ->badge($this->getCarritosCountByEstado('contactado')),
            'Confirmados' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('estado', 'confirmado'))
                ->badge($this->getCarritosCountByEstado('confirmado')),
            'Cancelados' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('estado', 'cancelado'))
                ->badge($this->getCarritosCountByEstado('cancelado')),
        ];
    }
}
