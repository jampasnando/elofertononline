<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Detalleventa extends Model
{
    protected $table = 'detalleventas';

    public function vendedor()
    {
        return $this->belongsTo(Vendedor::class, 'vendedor', 'id');
    }
}
