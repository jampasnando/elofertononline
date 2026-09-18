<?php

namespace App\Filament\Especial\Resources\Comisiones\Pages;

use App\Filament\Especial\Resources\Comisiones\ComisionesResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditComisiones extends EditRecord
{
    protected static string $resource = ComisionesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
