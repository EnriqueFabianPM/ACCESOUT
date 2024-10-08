<?php

namespace App\Imports;

use App\Models\Estudiante;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EstudiantesImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {
            // Skip rows with missing identificador or nombre
            if (empty($row['identificador']) || empty($row['nombre'])) {
                continue;
            }

            // Prepare validated data
            $validatedData = [
                'identificador' => $row['identificador'],
                'nombre' => $row['nombre'],
                'apellidos' => $row['apellidos'] ?? null,
                'semestre' => $row['semestre'] ?? null,
                'grupo' => $row['grupo'] ?? null,
                'email' => $row['email'] ?? null,
            ];

            // Update or create the student record
            Estudiante::updateOrCreate(
                ['identificador' => $validatedData['identificador']],
                $validatedData
            );
        }
    }
}
