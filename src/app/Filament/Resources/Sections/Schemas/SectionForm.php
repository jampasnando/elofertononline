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
use Filament\Forms\Components\RichEditor;


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
            if($type != 'marcas' && $type != 'lista1' && $type != 'lista2') {
                $productos = Inventario::where('cantidad', '>', 0)->get()->mapWithKeys(function ($p) {
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
            if($type == 'lista1') {
                $listacategorias = Inventario::query()
                                 ->select('categoria')
                                 ->distinct()
                                 ->orderBy('categoria')
                                 ->get()
                                 ->pluck('categoria', 'categoria')
                                 ->toArray();
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
                case 'cards5':
                             return Repeater::make('parametros')
                                ->label('Cards')
                                ->minItems(1)
                                ->schema([
                                    fileUpload::make('imagen')
                                        ->label('Una Imagen')
                                        ->disk('public')
                                        ->directory('cards')
                                        ->visibility('public')
                                        ->required(),
                                    TextArea::make('texto')
                                        ->label('Texto de la card'),
                                    TextInput::make('productos')
                                        ->label('SKUs de productos (separados por coma)')
                                       ->dehydrateStateUsing(function ($state) {
                                            // Guardar siempre como array en el JSON
                                            if (is_string($state)) {
                                                $arr = array_filter(array_map('trim', explode(',', $state)));
                                                return array_values($arr);
                                            }
                                            if (is_array($state)) {
                                                return array_values($state);
                                            }
                                            return [];
                                        })
                                        ->formatStateUsing(function ($state) {
                                            // Mostrar como "a, b, c" en el formulario al editar
                                            if (is_array($state)) {
                                                return implode(', ', $state);
                                            }
                                            return $state;
                                        }),
                                ])
                                ->columns(5);
                case 'libre':
                    return FieldSet::make('parametros')
                        ->schema([
                            RichEditor::make('contenido')
                            ->json()
                        ]);
                case 'destacados1':
                    return Fieldset::make('parametros')
                        ->label('Parámetros')
                        ->schema([
                            Section::make('')
                                ->schema([
                                    TextInput::make('titulo')
                                    ->label('Título de la sección')
                                    ->required()
                                    ->columnSpan(3),
                                    Select::make('titulofont')
                                    ->label('Tipo letra')
                                    ->options([
                                        ''=>'Normal',
                                        'font-bebas'=>'Bebas',
                                        'font-kanit'=>'Kanit',
                                        'font-impact'=>'Impact',
                                        'font-franklin'=>'Franklin'
                                    ])
                                    ->default('')
                                    ->columnSpan(1)
                                    ->dehydrated()
                                    ->native(false),
                                    Select::make('titulosize')
                                    ->label('Tamaño')
                                    ->options([
                                        ''=>'Normal',
                                        'fs-6'=>'1',
                                        'fs-5'=>'2',
                                        'fs-4'=>'3',
                                        'fs-3'=>'4',
                                        'fs-2'=>'5',
                                        'fs-1'=>'6',
                                    ])
                                    ->default('')
                                    ->placeholder('Elija')
                                    ->dehydrated()
                                    ->native(false),
                                    Toggle::make('titulobold')
                                    ->label('Negrita'),
                                    ColorPicker::make('titulocolor')
                                    ->label('Color del título'),
                                    ColorPicker::make('bgcolor')
                                    ->label('Color de fondo'),
                                ])
                                ->columns(8)
                                ->columnSpanFull(),
                            
                            fileUpload::make('imagen_destacada')
                                        ->label('Imagen destacada')
                                        ->disk('public')
                                        ->directory('destacados')
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
                                            // Log::info('p: ',$p);
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
                    return Fieldset::make('parametros')
                        ->label('Parámetros')   
                                ->schema([
                                    Section::make('') // Primera sección (titulox + imgx1..imgx4)xy
                                        ->schema([
                                                ColorPicker::make('color')
                                                ->label('Color de fondo toda la sección'),
                                                Select::make('titulofontX')
                                                ->label('Tipo letraX')
                                                ->options([
                                                    ''=>'Normal',
                                                    'font-bebas'=>'Bebas',
                                                    'font-kanit'=>'Kanit',
                                                    'font-impact'=>'Impact',
                                                    'font-franklin'=>'Franklin'
                                                ])
                                                ->default('')
                                                ->columnSpan(1)
                                                ->dehydrated()
                                                ->native(false),
                                                Select::make('tamtituloX')
                                                ->label('TamañoX')
                                                ->options([
                                                    ''=>'Normal',
                                                    'fs-6'=>'1',
                                                    'fs-5'=>'2',
                                                    'fs-4'=>'3',
                                                    'fs-3'=>'4',
                                                    'fs-2'=>'5',
                                                    'fs-1'=>'6',
                                                ])
                                                ->default('')
                                                ->placeholder('Elija')
                                                ->dehydrated()
                                                ->native(false),
                                                Toggle::make('negritaX')
                                                ->label('NegritaX'),
                                                ColorPicker::make('colorletraX')
                                                ->label('Color tituloX'),
                                                ColorPicker::make('bgcolorX')
                                                ->label('Color de fondoX'),
                                                //////////////////////// para Y ////////////////////////
                                                Select::make('titulofontY')
                                                ->label('Tipo letraY')
                                                ->options([
                                                    ''=>'Normal',
                                                    'font-bebas'=>'Bebas',
                                                    'font-kanit'=>'Kanit',
                                                    'font-impact'=>'Impact',
                                                    'font-franklin'=>'Franklin'
                                                ])
                                                ->default('')
                                                ->columnSpan(1)
                                                ->dehydrated()
                                                ->native(false),
                                                Select::make('tamtituloY')
                                                ->label('TamañoY')
                                                ->options([
                                                    ''=>'Normal',
                                                    'fs-6'=>'1',
                                                    'fs-5'=>'2',
                                                    'fs-4'=>'3',
                                                    'fs-3'=>'4',
                                                    'fs-2'=>'5',
                                                    'fs-1'=>'6',
                                                ])
                                                ->default('')
                                                ->placeholder('Elija')
                                                ->dehydrated()
                                                ->native(false),
                                                Toggle::make('negritaY')
                                                ->label('NegritaY'),
                                                ColorPicker::make('colorletraY')
                                                ->label('Color tituloY'),
                                                ColorPicker::make('bgcolorY')
                                                ->label('Color de fondoY'),
                                        ])
                                        ->columns(6)
                                        ->columnSpanFull(), 
                                                               
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
                                            TextInput::make('tituloY')
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
                                ->statePath('parametros');                 
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
                            Toggle::make('conimagenes')
                                ->label('Que tengan foto')
                                ->default(true),
                            Repeater::make('categorias')
                                ->label('Categorías')
                                ->schema([
                                    Select::make('categoria')->label('Categoría')
                                    ->options($listacategorias)
                                    ->searchable()
                                ]),
                            
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
                            
                        ])
                        ->columnSpanFull()
                        ->statePath('parametros');
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
                                'lista2' => 'Lista de productos de categorias...',
                                'libre' => 'Libre',
                                'cards5' => 'Cards',
                            ])
                            ->native(false)
                            ->reactive()
                            ->required()
                            ->columnSpan(2),
                        TextInput::make('descripcion')
                            ->columnSpan(4),
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
                            ->required()
                            ->default(0),
                    ])
                    ->columns(8)
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
