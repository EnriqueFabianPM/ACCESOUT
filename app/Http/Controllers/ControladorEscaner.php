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
                return redirect()->route("{$routePrefix}.entrada", $record->identificador);
            } elseif (is_null($record->salida)) {
                return redirect()->route("{$routePrefix}.salida", $record->identificador);
            }
            
            return redirect()->route('InicioGuardia')->with('error', 'Error al registrar persona.');
        }     
        return null;
    }

    public function searchEntradaByIdentifier(Request $request)
    {
        $identificador = $request->input('identificador');

        $estudiante = Estudiante::where('identificador', $identificador)->first();
        if ($estudiante) {
            return redirect()->route('estudiantes.entrada', $estudiante->identificador);
        }

        $empleado = Empleado::where('identificador', $identificador)->first();
        if ($empleado) {
            return redirect()->route('empleados.entrada', $empleado->identificador);
        }

        $visitante = Visitante::where('identificador', $identificador)->first();
        if ($visitante) {
            return redirect()->route('visitantes.entrada', $visitante->identificador);
        }

        return redirect()->route('guardia.matriculaentrada')->with('error', 'Identificador no encontrado.');
    }

    public function searchSalidaByIdentifier(Request $request)
    {
        $identificador = $request->input('identificador');

        $estudiante = Estudiante::where('identificador', $identificador)->first();
        if ($estudiante) {
            return redirect()->route('estudiantes.salida', $estudiante->identificador);
        }

        $empleado = Empleado::where('identificador', $identificador)->first();
        if ($empleado) {
            return redirect()->route('empleados.salida', $empleado->identificador);
        }

        $visitante = Visitante::where('identificador', $identificador)->first();
        if ($visitante) {
            return redirect()->route('visitantes.salida', $visitante->identificador);
        }

        return redirect()->route('guardia.matriculasalida')->with('error', 'Identificador no encontrado.');
    }
}
