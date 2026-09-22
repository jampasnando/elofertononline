<?php

namespace App\Filament\Resources\Inventarios\Pages;

use App\Filament\Resources\Inventarios\InventarioResource;
use App\Livewire\ProductosEnOferta;
use App\Livewire\ProductosSinStock;
use App\Models\Inventario;
use App\Services\InventarioCotizacionService;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListInventarios extends ListRecords
{
    protected static string $resource = InventarioResource::class;

    public function getHeaderWidgetsColumns(): int | array
    {
        return 2;
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('aplicar_cotizacion')
                ->label('Aplicar cotización')
                ->color('primary')
                ->icon('heroicon-o-currency-dollar')
                ->visible(fn () => auth()->user()->role === 'administrador')
                ->modalHeading('Actualizar precios de venta por cotización del dólar')
                ->modalDescription('Ingrese la cotización del dólar en bolivianos. Antes de aplicar, se creará una copia de seguridad de la tabla inventarios con la fecha y hora del cambio. El precio de venta se actualizará redondeando hacia arriba al entero más cercano.')
                ->form([
                    TextInput::make('cotizacion_dolar')
                        ->label('Cotización del dólar (Bs.)')
                        ->numeric()
                        ->required()
                        ->minValue(0)
                        ->step(0.01),
                ])
                ->action(function (array $data): void {
                    $cotizacion = (float) $data['cotizacion_dolar'];
                    $service = new InventarioCotizacionService();
                    $resultado = $service->aplicarCotizacion($cotizacion);

                    Notification::make()
                        ->success()
                        ->title('Cotización aplicada')
                        ->body('Se actualizó el precio de venta con cotización ' . number_format($cotizacion, 2, ',', '.') . ' Bs. y se creó la copia de seguridad ' . $resultado['tabla_backup'])
                        ->send();
                }),
            CreateAction::make(),
        ];
    }
    // public function getTabs(): array
    // {
    //     return [

    //         'Todo' => Tab::make()
    //             ->modifyQueryUsing(fn (Builder $query) => $query->where('estado', 'activo'))
    //             ->badge(Inventario::query()->where('estado', 'activo')->count()),
    //         'Inactivos' => Tab::make()
    //             ->modifyQueryUsing(fn (Builder $query) => $query->where('estado', 'inactivo'))
    //             ->badge(Inventario::query()->where('estado', 'inactivo')->count())
    //     ];
    // }
    protected function getHeaderWidgets(): array
    {
        return [
            ProductosEnOferta::class,
            // ProductosSinStock::class
        ];
    }


}
