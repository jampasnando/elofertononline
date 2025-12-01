<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carrusel;
use App\Models\Destacado;
use App\Models\Inventario;
use App\Models\Lista;
use App\Models\Marca;
use Illuminate\Support\Facades\Log;
use App\Models\Destacado2;
use App\Models\Section;

class MarketController extends Controller
{
    public function index()
    {
         $sections = Section::orderBy('orden')->get();

        // Si necesitas enriquecer algunos tipos de secciones
        $sections->transform(function ($section) {
            if ($section->tipo === 'destacados2') {
                $section->data = Inventario::whereIn('id', $section->parametros[0])->get();
            }
            if ($section->tipo === 'destacados1') {
                $section->data = Inventario::whereIn('id', $section->parametros['imagenes'])->get();
                // dd($section);
            }
            if ($section->tipo === 'marcas') {
                $section->data = Marca::whereIn('id', $section->parametros['imagenes'])->get();
                // dd($section);
            }
            if ($section->tipo ==='lista1')
            {
                $parametros = $section->parametros;
                $conimagenes = $parametros['conimagenes'];
                $categorias = $parametros['categorias'];
                // Obtener marcas en array simple
                $marcas = collect($parametros['marcas'])
                            ->pluck('marca')
                            ->toArray();

                // Consultar inventario
                if($conimagenes){
                    if(count($categorias)>0){
                        $productos = Inventario::whereIn('marca', $marcas)->whereNot('img1',NULL)->whereIn('categoria',$categorias)->paginate(12);
                    }
                    else{
                        $productos = Inventario::whereIn('marca', $marcas)->whereNot('img1',NULL)->paginate(12);
                    }
                }
                else{
                    if(count($categorias)>0){
                        $productos = Inventario::whereIn('marca', $marcas)->whereIn('categoria',$categorias)->paginate(12);
                    }
                    else{
                        $productos = Inventario::whereIn('marca', $marcas)->paginate(12);
                    }
                }
                $section->data = $productos;
            }
            return $section;
        });
        // dd($sections);
        // dd($sections[0]->data[3]->img1);
        return view('market.index', compact('sections'));
        // $destacados = Destacado::first();
        // $logos = Marca::where('carrusel', true)->get();
        // $productos=[];
        // if (!$destacados) {
        //     $productos=[];
        //     $imagen_destacada = '';
        // }
        // else{
        //     $productosIds = [
        //         $destacados->prod1,
        //         $destacados->prod2,
        //         $destacados->prod3,
        //         $destacados->prod4,
        //         $destacados->prod5,
        //         $destacados->prod6,
        //     ];
        //     $productos = Inventario::whereIn('id', $productosIds)->get();
        //     $imagen_destacada = $destacados->imgdestacada;
        //     $productos = $productos->sortBy(function($p) use ($productosIds) {
        //         return array_search($p->id, $productosIds);
        //     })->values();
        // }

        // $carruseles = Carrusel::orderBy('orden')->get();
        
        // $listas = Lista::conProductos();
        // $destacado2s = Destacado2::first();
        // $prods2x = Inventario::where('id',$destacado2s->imgx1)
        //             ->orWhere('id',$destacado2s->imgx2)
        //             ->orWhere('id',$destacado2s->imgx3)
        //             ->orWhere('id',$destacado2s->imgx4)
        //             ->get();
        // $prods2y = Inventario::where('id',$destacado2s->imgy1)
        //             ->orWhere('id',$destacado2s->imgy2)
        //             ->orWhere('id',$destacado2s->imgy3)
        //             ->orWhere('id',$destacado2s->imgy4)
        //             ->get();
        // return view('market.index', compact('carruseles', 'destacados', 'productos', 'imagen_destacada', 'logos', 'listas','destacado2s','prods2x','prods2y'));
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function buscar(Request $request)
    {
        $buscar = $request->input('buscar');

        // Realiza la búsqueda en el modelo Inventario
        $buscados = Inventario::where('descripcion', 'LIKE', "%{$buscar}%")
            ->orWhere('marca', 'LIKE', "%{$buscar}%")
            ->orWhere('categoria', 'LIKE', "%{$buscar}%")->limit(50)
            ->paginate(24)
            ->appends(['buscar' => $buscar]);

        // Retorna la vista con los resultados de la búsqueda
        $carruseles = Carrusel::orderBy('orden')->get();
        $logos = Marca::where('carrusel', true)->get();
        $productos=[];
        return view('market.resultadobusqueda', compact('productos','buscados','carruseles', 'logos', 'buscar'));
    }   
}
