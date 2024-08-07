<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use App\Models\Empleado;
use App\Models\Visitante;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ControladorGuardia extends Controller
{
    // Show the main page for the security guard
    public function index(): View
    {
        return view('InicioGuardia');
    }

    // Show the QR scanner page
    public function scanner(): View
    {
        return view('scanner');
    }

    // Register entry for students, employees, and visitors by ID
    public function registerEntrada(Request $request, $type): RedirectResponse
    {
        $request->validate(['id' => 'required|integer']);
        $model = $this->getModelByType($type);

        $record = $model::find($request->input('id'));

        if (!$record) {
            return redirect()->route('inicio.guardias')->with('error', 'Registro no encontrado.');
        }

        $record->entrada = now();
        $record->save();

        return redirect()->route('inicio.guardias')->with('success', 'Entrada registrada exitosamente.');
    }

    // Register exit for students, employees, and visitors by ID
    public function registerSalida(Request $request, $type): RedirectResponse
    {
        $request->validate(['id' => 'required|integer']);
        $model = $this->getModelByType($type);

        $record = $model::find($request->input('id'));

        if (!$record) {
            return redirect()->route('inicio.guardias')->with('error', 'Registro no encontrado.');
        }

        $record->salida = now();
        $record->save();

        return redirect()->route('inicio.guardias')->with('success', 'Salida registrada exitosamente.');
    }

    // Helper method to get the model based on type
    private function getModelByType($type)
    {
        switch ($type) {
            case 'estudiante':
                return Estudiante::class;
            case 'empleado':
                return Empleado::class;
            case 'visitante':
                return Visitante::class;
            default:
                abort(404, 'Tipo no válido');
        }
    }

    public function handleScan(Request $request): RedirectResponse
    {
        $request->validate([
            'type' => 'required|in:estudiantes,empleados,visitantes',
            'id' => 'required|integer',
        ]);
    
        $type = $request->input('type');
        $id = $request->input('id');
    
        // Determine the route based on the type
        switch ($type) {
            case 'estudiantes':
                return redirect()->route('estudiantes.entrada.form', ['id' => $id]);
            case 'empleados':
                return redirect()->route('empleados.entrada.form', ['id' => $id]);
            case 'visitantes':
                return redirect()->route('visitantes.entrada.form', ['id' => $id]);
            default:
                return redirect()->route('InicioGuardia')->with('error', 'Tipo de registro inválido.');
        }
    }
}
