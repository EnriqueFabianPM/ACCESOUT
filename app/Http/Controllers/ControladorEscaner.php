<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estudiante;
use App\Models\Empleado;
use App\Models\Visitante;
use Illuminate\Support\Facades\Log;

class ControladorEscaner extends Controller
{
    public function handleScan($qrCode)
    {
        try {
            // Handle the QR code scan for each type
            if ($redirect = $this->handleQrScan(Estudiante::class, 'estudiantes', $qrCode)) {
                return $redirect;
            }

            if ($redirect = $this->handleQrScan(Empleado::class, 'empleados', $qrCode)) {
                return $redirect;
            }

            if ($redirect = $this->handleQrScan(Visitante::class, 'visitantes', $qrCode)) {
                return $redirect;
            }

            // If QR code is not found in any table, redirect back with an error message
            return redirect()->back()->with('error', 'Código QR no encontrado.');
        } catch (\Exception $e) {
            Log::error('Error handling QR code scan: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al procesar el código QR.');
        }
    }

    // Helper method to handle QR code scan for different models
    private function handleQrScan($model, $routePrefix, $qrCode)
    {
        $record = $model::where('identificador', $qrCode)->first();

        if ($record) {
            if (is_null($record->entrada)) {
                return redirect()->route("{$routePrefix}.entrada", $record->id);
            } elseif (is_null($record->salida)) {
                return redirect()->route("{$routePrefix}.salida", $record->id);
            } else {
                return redirect()->route("{$routePrefix}.log");
            }
        }

        return null;
    }
}
