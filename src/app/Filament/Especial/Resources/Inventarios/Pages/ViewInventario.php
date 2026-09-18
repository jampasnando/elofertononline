<?php

namespace App\Filament\Especial\Resources\Inventarios\Pages;

use App\Filament\Especial\Resources\Inventarios\InventarioResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewInventario extends ViewRecord
{
    protected static string $resource = InventarioResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // EditAction::make(),
        ];
    }
}
