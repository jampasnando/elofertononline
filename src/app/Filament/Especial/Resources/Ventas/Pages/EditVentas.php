<?php

namespace App\Filament\Especial\Resources\Ventas\Pages;

use App\Filament\Especial\Resources\Ventas\VentasResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditVentas extends EditRecord
{
    protected static string $resource = VentasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
