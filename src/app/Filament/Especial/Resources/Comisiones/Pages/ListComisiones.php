<?php

namespace App\Filament\Especial\Resources\Comisiones\Pages;

use App\Filament\Especial\Resources\Comisiones\ComisionesResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListComisiones extends ListRecords
{
    protected static string $resource = ComisionesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // CreateAction::make(),
        ];
    }
}
