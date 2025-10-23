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

class MarketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $destacados = Destacado::first();
        $logos = Marca::where('carrusel', true)->get();
        $productos=[];
        if (!$destacados) {
            $productos=[];
            $imagen_destacada = '';
        }
        else{
            $productosIds = [
                $destacados->prod1,
                $destacados->prod2,
                $destacados->prod3,
                $destacados->prod4,
                $destacados->prod5,
                $destacados->prod6,
            ];

            // Obtener los productos de Inventario que correspondan a esos IDs
            $productos = Inventario::whereIn('id', $productosIds)->get();
            $imagen_destacada = $destacados->imgdestacada;
            // Si quieres mantener el orden de prod1..prod6
            
            $productos = $productos->sortBy(function($p) use ($productosIds) {
                return array_search($p->id, $productosIds);
            })->values();
        }

        $carruseles = Carrusel::orderBy('orden')->get();
        
        $listas = Lista::conProductos();
        $destacado2s = Destacado2::first();
        $prods2x = Inventario::where('id',$destacado2s->imgx1)
                    ->orWhere('id',$destacado2s->imgx2)
                    ->orWhere('id',$destacado2s->imgx3)
                    ->orWhere('id',$destacado2s->imgx4)
                    ->get();
        $prods2y = Inventario::where('id',$destacado2s->imgy1)
                    ->orWhere('id',$destacado2s->imgy2)
                    ->orWhere('id',$destacado2s->imgy3)
                    ->orWhere('id',$destacado2s->imgy4)
                    ->get();
        return view('market.index', compact('carruseles', 'destacados', 'productos', 'imagen_destacada', 'logos', 'listas','destacado2s','prods2x','prods2y'));
    }

    /**
     * Show the form for creating a new resource.
     */
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
