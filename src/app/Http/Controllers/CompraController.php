<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\Detallecompra;
use Illuminate\Http\Request;

class CompraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("compras.index");
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
    public function show(Compra $compra)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Compra $compra)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Compra $compra)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Compra $compra)
    {
        //
    }
    public function detalleunacompra(Request $request){
        $compra=Compra::find($request->id);
        //$detalle=Detallecompra::where("idcompra",$request->idcompra)->get();
        $detalle = Detallecompra::where("detallecompras.idcompra", $request->idcompra)
        ->join("inventarios", "inventarios.id", "=", "detallecompras.idprod")
        ->select(
            "detallecompras.*",
            "inventarios.idprod as sku"
        )
        ->get();
        // $pagos=Pago::where("idcompra",$request->idcompra)->get();
        return view("compras.detalleunacompra")->with("compra",$compra)->with("detalle",$detalle);
    }
}
