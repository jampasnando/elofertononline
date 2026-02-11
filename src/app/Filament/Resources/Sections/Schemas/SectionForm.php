<?php

namespace App\Filament\Resources\Sections\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use App\Filament\Resources\Sections\Schemas\SectionTypes\CarouselType;
use App\Filament\Resources\Sections\Schemas\SectionTypes\Cards5Type;
use App\Filament\Resources\Sections\Schemas\SectionTypes\Destacados1Type;
use App\Filament\Resources\Sections\Schemas\SectionTypes\Destacados2Type;
use App\Filament\Resources\Sections\Schemas\SectionTypes\Destacados3Type;
use App\Filament\Resources\Sections\Schemas\SectionTypes\MarcasType;
use App\Filament\Resources\Sections\Schemas\SectionTypes\Lista1Type;


class SectionForm
{
    public static function configure(Schema $schema): Schema
    {
        function generateFormComponent($type)
        {
            return match($type) {
                'carousel' => CarouselType::getSchema(),
                'cards5' => Cards5Type::getSchema(),
                'destacados1' => Destacados1Type::getSchema(),
                'destacados2' => Destacados2Type::getSchema(),
                'destacados3' => Destacados3Type::getSchema(),
                'marcas' => MarcasType::getSchema(),
                'lista1' => Lista1Type::getSchema(),
                default => null,
            };
        }
        return $schema
            ->components([
                Section::make('')
                    ->label('')
                    ->description('')
                    ->schema([
                        Select::make('tipo')
                            ->label('Tipo de sección')
                            ->options([
                                'carousel' => 'Carrusel de Imágenes',
                                'destacados1' => 'Productos Destacados 1',
                                'destacados2' => 'Productos Destacados 2',
                                'destacados3' => 'Imagenes Destacadas',
                                'marcas' => 'Marcas Destacadas',
                                'lista1' => 'Lista de productos de marcas...',
                                'cards5' => 'Cards',
                            ])
                            ->native(false)
                            ->reactive()
                            ->required()
                            ->columnSpan(2),
                        TextInput::make('descripcion')
                            ->columnSpan(3),
                        Select::make('estado')
                            ->options([
                                'activo' => 'Activo',
                                'inactivo' => 'Inactivo',
                                'borrador'=>'Borrador',
                            ])
                            ->default('activo')
                            ->native(false)
                            ->required(),
                        TextInput::make('orden')
                            ->numeric()
                            ->required()
                            ->default(0),
                    ])
                    ->columns(7)
                    ->columnSpanFull(),

                Section::make('')
                    ->description('')
                        ->schema(function (callable $get) {
                            $type = $get('tipo');
                            if (!$type) {
                                return [];
                            }
                            return [
                                generateFormComponent($type),
                            ];
                    })
                    ->columnSpanFull()
                    ->reactive(),
            ]);
    }
}
