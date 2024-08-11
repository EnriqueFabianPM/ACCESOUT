<?php

namespace App\Exports;

use App\Models\Empleado;
use Maatwebsite\Excel\Concerns\FromCollection;

class EmpleadosExport implements FromCollection
{
    public function collection()
    {
        return Empleado::all();
    }   
}