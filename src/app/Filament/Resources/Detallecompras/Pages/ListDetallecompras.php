<?php

namespace App\Filament\Resources\Detallecompras\Pages;

use App\Filament\Resources\Detallecompras\DetallecompraResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDetallecompras extends ListRecords
{
    protected static string $resource = DetallecompraResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
