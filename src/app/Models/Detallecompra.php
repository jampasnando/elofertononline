<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Detallecompra extends Model
{
    //
    protected $fillable=['idcompra','idprod','cantidad','precio','subtotal'];
    public function compra(){
        return $this->belongsTo(Compra::class,'idcompra','idcompra');
    }
}
