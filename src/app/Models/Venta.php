<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table = 'ventas';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'idneg',
        'idventa',
        'total',
        'cliente',
        'telefono',
        'nit',
        'formapago',
        'fecha',
        'comentario',
        'vendedor',
        'idusr',
        'idcliente',
        'pago',
        'saldo',
        'pagomixto',
     ];
     protected $casts = [ 'fecha' => 'datetime', 'total' => 'float', 'pago' => 'float', 'saldo' => 'float', ];
}
