<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Exports\EmpleadosExport;
use App\Models\Empleado;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmpleadoQR;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\EmpleadosImport;

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
        ]);

        // Handle Foto upload
        if ($request->hasFile('Foto')) {
            $imagen = $request->file('Foto');
            $nombreImagen = 'Estudiante_' . $validatedData['identificador'] . '.jpg';
            $imagen->move(public_path('FotosEmpleados'), $nombreImagen);
            $validatedData['Foto'] = 'FotosEmpleados/' . $nombreImagen;
        }

        if ($request->filled('qrCodeData')) {
            $qrCodeData = $request->input('qrCodeData');
            $qrCodePath = $this->saveQRCodeImage($qrCodeData, 'ImagenesQREmpleados/' . $validatedData['identificador'] . '_CodigoQR.jpg');
            $validatedData['Fotoqr'] = $qrCodePath;
        }

        Empleado::create($validatedData);
        $this->sendQRCodeByEmail(Empleado::where('identificador', $validatedData['identificador'])->first());

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
        ]);

        // Handle Foto upload
        if ($request->hasFile('Foto')) {
            $imagen = $request->file('Foto');
            $nombreImagen = 'Estudiante_' . $validatedData['identificador'] . '.jpg';
            $imagen->move(public_path('FotosEmpleados'), $nombreImagen);
            $validatedData['Foto'] = 'FotosEmpleados/' . $nombreImagen;
        }

        if ($request->filled('qrCodeData')) {
            $qrCodeData = $request->input('qrCodeData');
            $qrCodePath = $this->saveQRCodeImage($qrCodeData, 'ImagenesQREmpleados/' . $validatedData['identificador'] . '_CodigoQR.jpg');
            $validatedData['Fotoqr'] = $qrCodePath;
        }

        $empleado->update($validatedData);

        // Send email with QR code attached
        $this->sendQRCodeByEmail(Empleado::where('identificador', $validatedData['identificador'])->first());

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

    public function saveQRCodeImage($qrCodeData, $filePath)
    {
        // Decode the QR code image data
        $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $qrCodeData));
    
        // Save the image to the specified path
        file_put_contents(public_path($filePath), $imageData);
    
        return $filePath;
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

    public function sendQRCode(Empleado $empleado)
    {
        $email = $empleado->email;
        $domain = substr(strrchr($email, "@"), 1);

        // Determine which mailer to use based on the email domain
        if ($domain === 'gmail.com' || $domain === 'googlemail.com') {
            Mail::mailer('smtp')->to($email)->send(new EmpleadoQR($empleado->Fotoqr));
        } elseif (in_array($domain, ['outlook.com', 'hotmail.com', 'live.com'])) {
            Mail::mailer('smtp_outlook')->to($email)->send(new EmpleadoQR($empleado->Fotoqr));
        } else {
            Mail::to($email)->send(new EmpleadoQR($empleado->Fotoqr));
        }

        return redirect()->route('empleados.index')->with('success', 'Código QR enviado correctamente.');
    }
    
    public function importFromExcel(Request $request)
    {
        $request->validate([
            'import_file' => 'required|mimes:xlsx'
        ]);

        $file = $request->file('import_file');
        Excel::import(new EmpleadosImport, $file);

        return redirect()->route('empleados.index')->with('success', 'Estudiantes importados exitosamente.');
    }

    public function export()
    {
        return Excel::download(new EmpleadosExport, 'empleados.xlsx');
    }

    public function updatePhoto(Request $request, $identificador)
    {
        $request->validate([
            'Foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $empleado = Empleado::where('identificador', $identificador)->firstOrFail();

        if ($empleado->Foto) {
            Storage::delete($empleado->Foto);
        }

        $foto = $request->file('Foto');
        $fotoPath = 'FotosEmpleados/Empleado_' . $identificador . '.' . $foto->getClientOriginalExtension();
        $foto->move(public_path('FotosEmpleados'), $fotoPath);

        $empleado->update(['Foto' => $fotoPath]);

        return redirect()->route('empleados.index', $identificador)->with('flash_message', 'Foto actualizada exitósamente!');
    }

    public function updateQRCode(Request $request, $identificador)
    {
        $request->validate([
            'qrCodeData' => 'required|string',
        ]);
    
        $empleado = Empleado::where('identificador', $identificador)->firstOrFail();

        if ($empleado->Fotoqr) {
            Storage::delete($empleado->Fotoqr);
        }

        $qrCodeData = $request->input('qrCodeData');
        $qrCodePath = $this->saveQRCodeImage($qrCodeData, 'ImagenesQREmpleados/' . $identificador . '_CodigoQR.jpg');
    
        // Update the student's QR code path
        $empleado->Fotoqr = $qrCodePath;
        $empleado->save();
    
        return response()->json([
            'success' => true,
            'filePath' => asset($qrCodePath),
        ]);
    }
}