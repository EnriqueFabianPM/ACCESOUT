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

            // Extract data from the row
            $identificador = $row['identificador'];
            $fotoPath = $row['Foto'] ?? null;

            // Prepare validated data
            $validatedData = [
                'identificador' => $identificador,
                'Fotoqr' => $row['Fotoqr'] ?? null, // Ensure this is correct if QR code path is included in the Excel file
                'Foto' => $this->processFilePath($fotoPath),
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

    private function processFilePath($path)
    {
        // Handle file paths by removing 'file:///' prefix if present
        if (!$path) {
            return null;
        }

        // Remove 'file:///' from the path if it exists
        $path = str_replace('file:///', '', $path);

        // Return the relative path to the public directory
        return $path ? 'FotosEstudiantes/' . basename($path) : null;
    }
}
