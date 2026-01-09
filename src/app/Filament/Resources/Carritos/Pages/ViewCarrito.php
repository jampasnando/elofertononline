<?php

namespace App\Filament\Resources\Carritos\Pages;

use App\Filament\Resources\Carritos\CarritoResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewCarrito extends ViewRecord
{
    protected static string $resource = CarritoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
