<?php

namespace App\Filament\Especial\Resources\Detalleventas\Pages;

use App\Filament\Especial\Resources\Detalleventas\DetalleventasResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditDetalleventas extends EditRecord
{
    protected static string $resource = DetalleventasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // DeleteAction::make(),
        ];
    }
}
