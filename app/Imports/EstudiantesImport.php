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
        // Handle URLs or file paths for images
        if (!$path) {
            return null;
        }

        $fileName = time() . '_' . basename($path);
        $destinationPath = public_path('FotosEstudiantes/' . $fileName);

        try {
            // Handle URL or local path copying
            if (filter_var($path, FILTER_VALIDATE_URL)) {
                // If path is a URL, download and save the image
                $imageContents = file_get_contents($path);
                if ($imageContents !== false) {
                    file_put_contents($destinationPath, $imageContents);
                    return 'FotosEstudiantes/' . $fileName;
                }
            } elseif (file_exists($path)) {
                // If path is a local file, copy it
                copy($path, $destinationPath);
                return 'FotosEstudiantes/' . $fileName;
            }
        } catch (\Exception $e) {
            \Log::error("Error processing file path: " . $e->getMessage());
        }

        return null;
    }
}
