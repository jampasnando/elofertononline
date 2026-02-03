<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    //
    protected $fillable = ['idprod', 'marca', 'cantidad', 'categoria', 'unidad', 'preciolocal', 'precioventa', 'comision', 'deposito', 'proveedor', 'descripcion', 'imagenes', 'img1', 'img2', 'img3'];
    
    public function ofertas()
    {
        return $this->hasMany(Oferta::class);
    }

    public function ofertaActiva()
    {
        return $this->hasOne(Oferta::class)
            ->where('activo', 1)
            ->whereDate('fecha_inicio', '<=', now())
            ->whereDate('fecha_fin', '>=', now());
    }
}
