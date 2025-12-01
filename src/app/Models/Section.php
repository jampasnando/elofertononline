<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    //
    protected $fillable = [
        'tipo',
        'parametros',
        'estado',
        'orden',
    ];  
    protected $casts = [
        'parametros' => 'array',
    ];
}
