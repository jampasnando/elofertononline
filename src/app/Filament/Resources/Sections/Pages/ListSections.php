<?php

namespace App\Filament\Resources\Sections\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\Sections\SectionResource;
use App\Models\Section;

class ListSections extends ListRecords
{
    protected static string $resource = SectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
    public function getTabs(): array
    {
        return [

            'Activos' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('estado', 'activo'))
                ->badge(Section::query()->where('estado', 'activo')->count()),
            'Inactivos' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('estado', 'inactivo'))
                ->badge(Section::query()->where('estado', 'inactivo')->count()),
            'Borradores' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('estado', 'borrador'))
                ->badge(Section::query()->where('estado', 'borrador')->count()),
        ];
    }
}
