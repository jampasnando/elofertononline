<?php

namespace App\Filament\Resources\Destacados\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use App\Models\Inventario;
use Filament\Actions\Action;

class DestacadoForm
{
    public static function configure(Schema $schema): Schema
    {
        $productos = Inventario::all()->mapWithKeys(function ($p) {
            if($p->img1 == NULL) {
                $foto= 'NoFoto';
            }
            else {
                $foto= 'HayFoto';
            }
            return [
                $p->id => "{$p->descripcion} - Bs. {$p->precioventa} - Stock: {$p->cantidad} ({$foto})",
            ];
        })->toArray();
        return $schema
            ->components([
                TextInput::make('titulo'),
                TextInput::make('orden')
                    ->required()
                    ->numeric()
                    ->default(0),
                
                FileUpload::make('imgdestacada')
                    ->image()
                    ->disk('public')
                    ->directory('destacados')
                    ->downloadable()
                    ->visibility('public')
                    ->imageEditor()
                    ->required(),
                Select::make('prod1')->label('Producto 1')->options($productos)->searchable()
                ->suffixAction(
                    Action::make('editar')
                        ->label('Editar')
                        ->icon('heroicon-o-pencil-square')
                        ->url(fn ($get) => $get('prod1') 
                            ? route('filament.admin.resources.inventarios.edit', $get('prod1'))
                            : null
                        )
                        ->openUrlInNewTab()
                        ->disabled(fn ($get) => blank($get('prod1')))
                )
                ->preload(),
                Select::make('prod2')->label('Producto 2')->options($productos)->searchable()
                ->suffixAction(
                    Action::make('editar')
                        ->label('Editar')
                        ->icon('heroicon-o-pencil-square')
                        ->url(fn ($get) => $get('prod2') 
                            ? route('filament.admin.resources.inventarios.edit', $get('prod2'))
                            : null
                        )
                        ->openUrlInNewTab()
                        ->disabled(fn ($get) => blank($get('prod1')))
                )
                ->preload(),
                Select::make('prod3')->label('Producto 3')->options($productos)->searchable()
                ->suffixAction(
                    Action::make('editar')
                        ->label('Editar')
                        ->icon('heroicon-o-pencil-square')
                        ->url(fn ($get) => $get('prod3') 
                            ? route('filament.admin.resources.inventarios.edit', $get('prod3'))
                            : null
                        )
                        ->openUrlInNewTab()
                        ->disabled(fn ($get) => blank($get('prod1')))
                )
                ->preload(),
                Select::make('prod4')->label('Producto 4')->options($productos)->searchable()
                ->suffixAction(
                    Action::make('editar')
                        ->label('Editar')
                        ->icon('heroicon-o-pencil-square')
                        ->url(fn ($get) => $get('prod4') 
                            ? route('filament.admin.resources.inventarios.edit', $get('prod4'))
                            : null
                        )
                        ->openUrlInNewTab()
                        ->disabled(fn ($get) => blank($get('prod1')))
                )
                ->preload(),
                Select::make('prod5')->label('Producto 5')->options($productos)->searchable()
                ->suffixAction(
                    Action::make('editar')
                        ->label('Editar')
                        ->icon('heroicon-o-pencil-square')
                        ->url(fn ($get) => $get('prod5') 
                            ? route('filament.admin.resources.inventarios.edit', $get('prod5'))
                            : null
                        )
                        ->openUrlInNewTab()
                        ->disabled(fn ($get) => blank($get('prod1')))
                )
                ->preload(),
                Select::make('prod6')->label('Producto 6')->options($productos)->searchable()
                ->suffixAction(
                    Action::make('editar')
                        ->label('Editar')
                        ->icon('heroicon-o-pencil-square')
                        ->url(fn ($get) => $get('prod6') 
                            ? route('filament.admin.resources.inventarios.edit', $get('prod6'))
                            : null
                        )
                        ->openUrlInNewTab()
                        ->disabled(fn ($get) => blank($get('prod1')))
                )
                ->preload(),
                Toggle::make('estado')
                    ->label('Activo')
                    ->default(false),
            ]);
    }
}
