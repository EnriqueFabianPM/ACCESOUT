<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estudiante;
use App\Models\Empleado;
use App\Models\Visitante;
use Illuminate\Support\Facades\Log;

class ControladorEntradasSalidas extends Controller
{
    // Register entry for a record
    public function registrarEntrada($identificador)
    {
        try {
            $record = $this->findRecordByIdentificador($identificador);
            if (!$record) {
                return redirect()->route('InicioGuardia')->with('error', 'Registro no encontrado.');
            }

            if (!is_null($record->entrada)) {
                return redirect()->route('InicioGuardia')->with('error', 'La entrada ya ha sido registrada.');
            }

            $record->entrada = now();
            $record->save();

            return redirect()->route('InicioGuardia')->with('success', 'Entrada registrada exitosamente.');

        } catch (\Exception $e) {
            Log::error('Error registering entry: ' . $e->getMessage());
            return redirect()->route('InicioGuardia')->with('error', 'Error al registrar la entrada.');
        }
    }

    // Register exit for a record
    public function registrarSalida($identificador)
    {
        try {
            $record = $this->findRecordByIdentificador($identificador);
            if (!$record) {
                return redirect()->route('InicioGuardia')->with('error', 'Registro no encontrado.');
            }

            if (!is_null($record->salida)) {
                return redirect()->route('InicioGuardia')->with('error', 'La salida ya ha sido registrada.');
            }

            $record->salida = now();
            $record->save();

            return redirect()->route('InicioGuardia')->with('success', 'Salida registrada exitosamente.');

        } catch (\Exception $e) {
            Log::error('Error registering exit: ' . $e->getMessage());
            return redirect()->route('InicioGuardia')->with('error', 'Error al registrar la salida.');
        }
    }

    private function findRecordByIdentificador($identificador)
    {
        $models = [Estudiante::class, Empleado::class, Visitante::class];
        foreach ($models as $model) {
            $record = $model::where('identificador', $identificador)->first();
            if ($record) {
                return $record;
            }
        }
        return null;
    }
}
