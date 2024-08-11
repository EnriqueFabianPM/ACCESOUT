<?php

namespace App\Imports;

use App\Models\Empleado;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EmpleadosImport implements ToCollection, WithHeadingRow
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
                'areatrabajo' => $row['areatrabajo'] ?? null,
                'telefono' => $row['telefono'] ?? null,
                'email' => $row['email'] ?? null,
            ];

            // Update or create the student record
            Empleado::updateOrCreate(
                ['identificador' => $validatedData['identificador']],
                $validatedData
            );
        }
    }
}