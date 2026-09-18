<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendedor extends Model
{
    protected $table = 'vendedores';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'ciudad',
        'nombre',
        'telefono',
     ];
}
