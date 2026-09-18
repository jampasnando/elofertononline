<?php

namespace App\Filament\Especial\Resources\Detalleventas\Pages;

use App\Filament\Especial\Resources\Detalleventas\DetalleventasResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDetalleventas extends ListRecords
{
    protected static string $resource = DetalleventasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // CreateAction::make(),
        ];
    }
}
