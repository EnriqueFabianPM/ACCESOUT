<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntradasSalidas extends Model
{
    use HasFactory;

    protected $table = 'entradas_y_salidas';

    protected $fillable = [
        'identificador', 
        'tipo',
        'caseta',
        'nombre',
        'apellidos', 
        'entrada', 
        'salida',
    ];
}
