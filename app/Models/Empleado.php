<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Empleado extends Model
{
    protected $table = 'empleados';
    protected $primaryKey = 'id';
    protected $fillable = [
        'Fotoqr',
        'Foto',
        'identificador',
        'nombre',
        'apellidos',
        'areatrabajo',
        'telefono',
        'email',
        'entrada',
        'salida',
    ];
    use HasFactory;

    public function logs()
    {
        return $this->morphMany(Log::class, 'user');
    }
}