<?php

namespace App\Filament\Resources\Detallecompras\Pages;

use App\Filament\Resources\Detallecompras\DetallecompraResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditDetallecompra extends EditRecord
{
    protected static string $resource = DetallecompraResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
