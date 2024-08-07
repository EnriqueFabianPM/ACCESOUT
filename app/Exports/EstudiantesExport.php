<?php

namespace App\Exports;

use App\Models\Estudiante;
use Maatwebsite\Excel\Concerns\FromCollection;

class EstudiantesExport implements FromCollection
{
    public function collection()
    {
        return Estudiante::all();
    }
}