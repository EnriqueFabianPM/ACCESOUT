<?php

namespace App\Exports;

use App\Models\Visitante;
use Maatwebsite\Excel\Concerns\FromCollection;

class VisitantesExport implements FromCollection
{
    public function collection()
    {
        return Visitante::all();
    }   
}