<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Detalleventa extends Model
{
    protected $table = 'detalleventas';

    public function vendedorRelacion()
    {
        return $this->belongsTo(Vendedor::class, 'vendedor', 'id');
    }
}
