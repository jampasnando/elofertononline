<?php

namespace App\Filament\Resources\Compras\RelationManagers;

use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DetallecomprasRelationManager extends RelationManager
{
    protected static string $relationship = 'detallecompras';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('idcompra')
                    ->required(),
                TextInput::make('idprod')
                    ->required(),
                Textarea::make('descripcion')
                    ->columnSpanFull(),
                TextInput::make('preciolocal')
                    ->required()
                    ->numeric(),
                TextInput::make('cuantos')
                    ->required()
                    ->numeric(),
                DateTimePicker::make('registrado'),
            ])
            ->columns(4);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('unacompra')
            ->columns([
                TextColumn::make('idcompra')
                    ->searchable(),
                TextColumn::make('idprod')
                    ->searchable()
                    ->url(fn ($record) => route(
                        'filament.admin.resources.inventarios.edit',
                        ['record' => $record->idprod]
                    ))
                    ->openUrlInNewTab(),
                // TextColumn::make('preciolocal')
                //     ->numeric()
                //     ->sortable(),
                TextColumn::make('cuantos')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('registrado')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('registrado', 'desc')
            ->filters([
                //
            ])
            ->headerActions([
                // CreateAction::make(),
                // AssociateAction::make(),
            ])
            ->recordActions([
                // EditAction::make(),
                // DissociateAction::make(),
                // DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    // DissociateBulkAction::make(),
                    // DeleteBulkAction::make(),
                ]),
            ]);
    }
}
