<?php

namespace App\Filament\Resources\Sections\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Actions\Action;
use Illuminate\Support\HtmlString;
use App\Models\Inventario;
use Illuminate\Support\Facades\Log;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Fieldset;
use App\Models\Marca;


class SectionForm
{
    public static function configure(Schema $schema): Schema
    {
        // $productos = Inventario::all()->mapWithKeys(function ($p) {
        //     if($p->img1 == NULL) {
        //         $foto= 'NoFoto';
        //     }
        //     else {
        //         $foto= 'HayFoto';
        //     }
        //     return [
        //         $p->id => "{$p->descripcion} - Bs. {$p->precioventa} - Stock: {$p->cantidad} ({$foto})",
        //     ];
        // })->toArray();
        
        function generateFormComponent($type)
        {
            if($type != 'marcas' && $type != 'lista1') {
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
            }
            if($type == 'marcas' || $type == 'lista1') {
                $marcas = Marca::orderBy('logo','desc')->orderBy('nombre')->get()->mapWithKeys(function ($p) {
                    if($p->logo == NULL) {
                        $foto= 'NoFoto';
                    }
                    else {
                        $foto= 'HayFoto';
                    }
                    return [
                        $p->id => "{$p->nombre} - ({$foto})",
                    ];
                    })->toArray();
            }
            switch ($type) {
                case 'carousel':
                             return Repeater::make('parametros')
                                ->label('Imágenes del Carrusel')
                                ->minItems(1)
                                ->schema([
                                    fileUpload::make('unaimagen')
                                        ->label('Una Imagen')
                                        ->disk('public')
                                        ->directory('carruseles')
                                        ->visibility('public')
                                        ->required(),
                                ])
                        ->columnSpanFull();
                case 'destacados1':
                    return Fieldset::make('parametros')
                        ->schema([
                            TextInput::make('titulo')
                                ->label('Título de la sección')
                                ->required(),
                            fileUpload::make('imagen_destacada')
                                        ->label('Imagen destacada')
                                        ->disk('public')
                                        ->directory('destacaddos')
                                        ->visibility('public')
                                        ->required(),
                           Repeater::make('imagenes')
                            ->label('Productos Destacados')
                            ->minItems(6)
                            ->maxItems(6)
                            ->validationMessages([
                                'min' => 'Debes agregar 6 imágenes',
                            ])
                            ->schema([
                                Grid::make()
                                ->schema([
                                    Placeholder::make('Imagen')
                                        ->label('')
                                        ->reactive()
                                        ->content(function ($get) {
                                            $id = $get('producto');
                                            // imagen por defecto si no hay producto o imagen
                                            $default = asset('imagenes/toolsplaceholder.png');
                                            if (! $id) {
                                                return new HtmlString('<img src="'.$default.'" style="width:64px;height:64px;object-fit:cover;border-radius:8px;">');
                                            }
                                            $p = Inventario::find($id);
                                            if (! $p || ! $p->img1) {
                                                return new HtmlString('<img src="'.$default.'" style="width:64px;height:64px;object-fit:cover;border-radius:8px;">');
                                            }
                                            $path = asset('storage/' . $p->img1);
                                            return new HtmlString('<img src="'.$path.'" style="width:64px;height::64px;object-fit:cover;border-radius:8px;">');
                                        })
                                        ->columnSpan(1),
                                    Select::make('producto')->label('Producto')
                                        ->options($productos)->searchable()
                                        ->suffixAction(
                                            Action::make('editar')
                                                ->label('Editar')
                                                ->icon('heroicon-o-pencil-square')
                                                ->url(fn ($get) => $get('producto') 
                                                    ? route('filament.admin.resources.inventarios.edit', $get('producto'))
                                                    : null
                                                )
                                                ->openUrlInNewTab()
                                                ->disabled(fn ($get) => blank($get('producto')))
                                        )
                                        ->reactive()
                                        ->preload()
                                        // ->columns(2),
                                ])
                                // ->columns(2)
                            ])
                            // ->columns(2)
                            ->columnSpan(2),
                        ])
                        ->statePath('parametros');
                case 'destacados2':
                    // $productos = Inventario::all()->mapWithKeys(function ($p) {
                    //         return [
                    //             $p->id => "{$p->descripcion} - Bs. {$p->precioventa} - Stock: {$p->cantidad}"
                    //         ];
                    //     })->toArray();
                    return Section::make('Destacados 2 Settings')
                        ->schema([
                            Repeater::make('parametros')
                                ->schema([
                                    Section::make('') // Primera sección (titulox + imgx1..imgx4)xy
                                        ->schema([
                                            ColorPicker::make('color')
                                                ->label('Color de fondox'),
                                                // ->columnSpanFull(),
                                            // Toggle::make('estado'),
                                            // TextInput::make('orden')
                                            //     ->numeric()
                                            //     ->default(0),
                                        ])
                                ->columns(3),
                            
                                Section::make('Sección X')
                                    ->schema([
                                        TextInput::make('titulox'),
                                        
                                        Grid::make(2) // 4 columnas para que las imágenes vayan en una sola fila
                                            ->schema([
                                                Select::make('imgx1')->label('Producto 1')->options($productos)->searchable()
                                                ->preload(),
                                                Select::make('imgx2')->label('Producto 2')->options($productos)->searchable()
                                                ->preload(),
                                                Select::make('imgx3')->label('Producto 3')->options($productos)->searchable()
                                                ->preload(),
                                                Select::make('imgx4')->label('Producto 4')->options($productos)->searchable()
                                                ->preload(),
                                            ]),
                                    ]),

                                // Segunda sección (tituloy + imgy1..imgy4)
                                Section::make('Sección Y')
                                    ->schema([
                                        TextInput::make('tituloy')
                                            ->columnSpanFull(),

                                        Grid::make(2) // 4 columnas para que las imágenes vayan en una sola fila
                                            ->schema([
                                                Select::make('imgy1')->label('Producto 5')->options($productos)->searchable()
                                                ->preload(),
                                                Select::make('imgy2')->label('Producto 6')->options($productos)->searchable()
                                                ->preload(),
                                                Select::make('imgy3')->label('Producto 7')->options($productos)->searchable()
                                                ->preload(),
                                                Select::make('imgy4')->label('Producto 8')->options($productos)->searchable()
                                                ->preload(),
                                            ]),
                                    ]),

                                // Otros campos
                                ])
                                ->minItems(1)
                                ->maxItems(1),
                            
                            
                        ]);
                case 'marcas':
                    return Fieldset::make('parametros')
                        ->schema([
                            TextInput::make('titulo')
                                ->label('Título de la sección')
                                ->required(),
                           Repeater::make('imagenes')
                            ->label('Marcas')
                            ->minItems(5)
                            // ->validationMessages([
                            //     'min' => 'Debes agregar 6 imágenes',
                            // ])
                            ->schema([
                                Grid::make()
                                ->schema([
                                    Placeholder::make('Imagen')
                                        ->label('')
                                        ->reactive()
                                        ->content(function ($get) {
                                            $id = $get('marca');
                                            // imagen por defecto si no hay producto o imagen
                                            $default = asset('imagenes/toolsplaceholder.png');
                                            if (! $id) {
                                                return new HtmlString('<img src="'.$default.'" style="width:64px;height:64px;object-fit:cover;border-radius:8px;">');
                                            }
                                            $p = Marca::find($id);
                                            if (! $p || ! $p->logo) {
                                                return new HtmlString('<img src="'.$default.'" style="width:64px;height:64px;object-fit:cover;border-radius:8px;">');
                                            }
                                            $path = asset('storage/' . $p->logo);
                                            return new HtmlString('<img src="'.$path.'" style="width:64px;height::64px;object-fit:cover;border-radius:8px;">');
                                        })
                                        ->columnSpan(1),
                                    Select::make('marca')->label('Marca')
                                        ->options($marcas)->searchable()
                                        ->suffixAction(
                                            Action::make('editar')
                                                ->label('Editar')
                                                ->icon('heroicon-o-pencil-square')
                                                ->url(fn ($get) => $get('marca') 
                                                    ? route('filament.admin.resources.marcas.edit', $get('marca'))
                                                    : null
                                                )
                                                ->openUrlInNewTab()
                                                ->disabled(fn ($get) => blank($get('marca')))
                                        )
                                        ->reactive()
                                        ->preload()
                                        // ->columns(2),
                                ])
                                // ->columns(2)
                            ])
                            // ->columns(2)
                            ->columnSpan(2),
                        ])
                        ->statePath('parametros');
                case 'lista1':
                    return Fieldset::make('parametros')
                        ->schema([
                            TextInput::make('titulo')
                                ->required()
                                ->maxLength(255),
                            Select::make('categorias')
                                ->label('Categorías')
                                ->multiple()                      // ← permite seleccionar varias
                                ->options(
                                    Inventario::query()
                                        ->select('categoria')
                                        ->distinct()              // ← evita duplicados
                                        ->orderBy('categoria')
                                        ->pluck('categoria', 'categoria')  // key => value
                                )
                                ->searchable(),               // opcional
                                // ->required()
                            
                            Repeater::make('marcas')
                                ->label('Marcas')
                                ->schema([
                                    Select::make('marca')->label('Marca')
                                        ->options(Marca::pluck('nombre','nombre'))
                                        ->searchable()
                                        ->preload()
                                ])
                                ->minItems(1)
                                ->createItemButtonLabel('Agregar marca')
                                ->validationMessages([
                                    'min' => 'Debes agregar al menos una marca.',
                                ])
                                ->columns(1),
                            Toggle::make('conimagenes')
                                ->label('Que tengan foto')
                                ->default(true),
                        ])
                        ->columnSpanFull()
                        ->statePath('parametros');
                default:
                    return null;
            }
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
                                'marcas' => 'Marcas Destacadas',
                                'lista1' => 'Lista de productos de marcas...',

                            ])
                            ->native(false)
                            ->reactive()
                            ->required(),
                        Select::make('estado')
                            ->options([
                                'activo' => 'Activo',
                                'inactivo' => 'Inactivo',
                            ])
                            ->default('activo')
                            ->native(false)
                            ->required(),
                        TextInput::make('orden')
                            ->numeric()
                            ->label('Orden de aparición')
                            ->required()
                            ->default(0),
                    ])
                    ->columns(3)
                    ->columnSpanFull(),
                
                Section::make('')
                    ->description('')
                        ->schema(function (callable $get) {
                            $type = $get('tipo'); // Obtiene el valor actual del campo 'type'
                            if (!$type) {
                                return []; // Si no hay un tipo seleccionado, no se muestra nada
                            }
                            return [
                                generateFormComponent($type), // Genera dinámicamente el componente basado en el tipo
                            ];
                    })
                    ->columnSpanFull()
                    ->reactive(),
            ]);
    }
}
