<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmpleadoQR;

class ControladorEmpleado extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $empleados = Empleado::paginate(10); // Ejemplo: paginar cada 10 resultados
        return view('empleados.index', compact('empleados'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('empleados.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'Foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',   // Adjusted to image validation
            'identificador' => 'required|string|max:255',
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'areatrabajo' => 'required|string|max:255',
            'telefono' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:empleados',
            'entrada' => 'nullable|date',
            'salida' => 'nullable|date',
        ]);

        // Handle Foto upload
        if ($request->hasFile('Foto')) {
            $imagen = $request->file('Foto');
            $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
            $rutaImagen = $imagen->move(public_path('FotosEmpleados'), $nombreImagen);
            $validatedData['Foto'] = 'FotosEmpleados/' . $nombreImagen;
        }
        
        if ($request->filled('qrCodeData')) {
            $qrCodeData = $request->input('qrCodeData');
            $qrCodePath = $this->saveQRCode($qrCodeData);
            $validatedData['Fotoqr'] = $qrCodePath;
        }

        // Create student record
        $empleado = Empleado::create($validatedData);

        // Send email with QR code attached
        $this->sendQRCodeByEmail($empleado);
        return redirect()->route('empleados.index')->with('flash_message', 'Empleado dado de alta exitósamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show($identificador): View
    {
        $empleado = Empleado::where('identificador', $identificador)->firstOrFail();
        return view('empleados.show', compact('empleado'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($identificador): View
    {
        $empleado = Empleado::where('identificador', $identificador)->firstOrFail();
        return view('empleados.edit', compact('empleado'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Empleado $empleado): RedirectResponse
    {
        $validatedData = $request->validate([
            'Fotoqr' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Adjusted to image validation
            'Foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',   // Adjusted to image validation
            'identificador' => 'required|string|max:255',
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'areatrabajo' => 'required|string|max:255',
            'telefono' => 'required|string|max:255', 
            'email' => 'required|string|email|max:255|unique:empleados,email,' . $empleado->id,
            'entrada' => 'nullable|date',
            'salida' => 'nullable|date',
        ]);

        // Handle Foto upload
        if ($request->hasFile('Foto')) {
            $imagen = $request->file('Foto');
            $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
            $rutaImagen = $imagen->move(public_path('FotosEmpleados'), $nombreImagen);
            $validatedData['Foto'] = 'FotosEmpleados/' . $nombreImagen;
        }

        if ($request->filled('qrCodeData')) {
            $qrCodeData = $request->input('qrCodeData');
            $qrCodePath = $this->saveQRCode($qrCodeData);
            $validatedData['Fotoqr'] = $qrCodePath;
        }

        $empleado->update($validatedData);

        // Send email with QR code attached
        $this->sendQRCodeByEmail($empleado);

        return redirect()->route('empleados.index')->with('flash_message', 'Registro de empleado actualizado exitósamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($identificador): RedirectResponse
    {
        $empleado = Empleado::where('identificador', $identificador)->firstOrFail();
        $empleado->delete();
        return redirect()->route('empleados.index')->with('flash_message', 'Registro de empleado eliminado exitósamente!');
    }

    private function saveQRCode($qrCodeData)
    {
        $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $qrCodeData));
        $qrCodePath = 'ImagenesQREmpleados/' . time() . '_qrcode.jpg';
        file_put_contents(public_path($qrCodePath), $imageData);

        return $qrCodePath;
    }

    /**
     * Send QR code to visitante's email address.
     */
    private function sendQRCodeByEmail(Empleado $empleado)
    {
        $email = $empleado->email;
        $domain = substr(strrchr($email, "@"), 1);

        if ($domain === 'gmail.com' || $domain === 'googlemail.com') {
            Mail::mailer('smtp')->to($email)->send(new EmpleadoQR($empleado->Fotoqr));
        } elseif (in_array($domain, ['outlook.com', 'hotmail.com', 'live.com'])) {
            Mail::mailer('smtp_outlook')->to($email)->send(new EmpleadoQR($empleado->Fotoqr));
        } else {
            Mail::to($email)->send(new EmpleadoQR($empleado->Fotoqr));
        }
    }
}