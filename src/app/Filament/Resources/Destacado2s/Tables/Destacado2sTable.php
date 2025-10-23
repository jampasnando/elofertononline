<?php

namespace App\Filament\Resources\Destacado2s\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class Destacado2sTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('titulox')
                    ->searchable(),
                TextColumn::make('imgx1')
                    ->searchable(),
                TextColumn::make('imgx2')
                    ->searchable(),
                TextColumn::make('imgx3')
                    ->searchable(),
                TextColumn::make('imgx4')
                    ->searchable(),
                TextColumn::make('tituloy')
                    ->searchable(),
                TextColumn::make('imgy1')
                    ->searchable(),
                TextColumn::make('imgy2')
                    ->searchable(),
                TextColumn::make('imgy3')
                    ->searchable(),
                TextColumn::make('imgy4')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('estado')
                    ->boolean(),
                TextColumn::make('orden')
                    ->numeric()
                    ->sortable(),
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
