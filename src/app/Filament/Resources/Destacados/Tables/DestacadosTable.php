<?php

namespace App\Filament\Resources\Destacados\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;
use App\Models\Inventario;

class DestacadosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('titulo')
                    ->searchable(),
                TextColumn::make('orden')
                    ->numeric()
                    ->sortable(),
                ImageColumn::make('imgdestacada')
                    ->label('Destacada')
                    ->disk('public')
                    ->visibility('public')
                    ->square() // opcional: recorta cuadrado
                    ->size(80)
                    ->url(fn ($record) => asset('storage/' . $record->imgdestacada)) // link directo a la imagen
                    ->openUrlInNewTab(), // tamaño del
                ImageColumn::make('prod1')
                    ->label('Prod1')
                    ->disk('public')
                    ->visibility('public')
                    ->square() // opcional: recorta cuadrado
                    ->size(55)
                    ->url(function ($record)  {
                        $producto = Inventario::find($record->prod1);
                        return $producto ? asset('storage/' . $producto->img1) : null;
                    }) // link directo a la imagen
                    ->openUrlInNewTab(),
                TextColumn::make('prod2')
                    ->searchable(),
                TextColumn::make('prod3')
                    ->searchable(),
                TextColumn::make('prod4')
                    ->searchable(),
                TextColumn::make('prod5')
                    ->searchable(),
                TextColumn::make('prod6')
                    ->searchable(),
                IconColumn::make('estado')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
