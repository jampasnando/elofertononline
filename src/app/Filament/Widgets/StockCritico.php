<?php

namespace App\Filament\Widgets;

use App\Models\Inventario;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class StockCritico extends BaseWidget
{
    protected static ?string $heading = 'Stock crítico';

    protected static ?string $pollingInterval = null;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Inventario::query()
                    ->where('inventarios.cantidad', '<=', 5)
                    ->limit(10)
            )
            ->columns([
                Tables\Columns\TextColumn::make('descripcion')
                    ->label('Producto'),

                Tables\Columns\TextColumn::make('cantidad')
                    ->label('Stock'),

                Tables\Columns\TextColumn::make('marca')
                    ->label('Marca'),
            ])
            ->paginated(false);
    }
}
