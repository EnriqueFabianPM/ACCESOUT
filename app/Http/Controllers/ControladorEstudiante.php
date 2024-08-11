<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Exports\EstudiantesExport;
use App\Models\Estudiante;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Mail;
use App\Mail\EstudianteQR;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\EstudiantesImport;

class ControladorEstudiante extends Controller
{
    public function index(): View
    {
        $estudiantes = Estudiante::paginate(10);
        return view('estudiantes.index', compact('estudiantes'));
    }

    public function create(): View
    {
        return view('estudiantes.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'Foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'identificador' => 'required|string|max:255',
            'nombre' => 'required|string|max:255',
            'apellidos' => 'nullable|string|max:255',
            'semestre' => 'nullable|string|max:255',
            'grupo' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:estudiantes',
        ]);

        if ($request->hasFile('Foto')) {
            $imagen = $request->file('Foto');
            $nombreImagen = 'Estudiante_' . $validatedData['identificador'] . '.jpg';
            $imagen->move(public_path('FotosEstudiantes'), $nombreImagen);
            $validatedData['Foto'] = 'FotosEstudiantes/' . $nombreImagen;
        }

        if ($request->filled('qrCodeData')) {
            $qrCodeData = $request->input('qrCodeData');
            $qrCodePath = $this->saveQRCodeImage($qrCodeData, 'ImagenesQREstudiantes/' . $validatedData['identificador'] . '_CodigoQR.jpg');
            $validatedData['Fotoqr'] = $qrCodePath;
        }

        Estudiante::create($validatedData);
        $this->sendQRCodeByEmail(Estudiante::where('identificador', $validatedData['identificador'])->first());

        return redirect()->route('estudiantes.index')->with('flash_message', 'Estudiante dado de alta exitósamente!');
    }

    public function show($identificador): View
    {
        $estudiante = Estudiante::where('identificador', $identificador)->firstOrFail();
        return view('estudiantes.show', compact('estudiante'));
    }

    public function edit($identificador): View
    {
        $estudiante = Estudiante::where('identificador', $identificador)->firstOrFail();
        return view('estudiantes.edit', compact('estudiante'));
    }

    public function update(Request $request, Estudiante $estudiante): RedirectResponse
    {
        $validatedData = $request->validate([
            'Fotoqr' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'Foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'identificador' => 'required|string|max:255',
            'nombre' => 'required|string|max:255',
            'apellidos' => 'nullable|string|max:255',
            'semestre' => 'nullable|string|max:255',
            'grupo' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:estudiantes,email,' . $estudiante->id,
        ]);

        if ($request->hasFile('Foto')) {
            $imagen = $request->file('Foto');
            $nombreImagen = 'Estudiante_' . $validatedData['identificador'] . '.jpg';
            $imagen->move(public_path('FotosEstudiantes'), $nombreImagen);
            $validatedData['Foto'] = 'FotosEstudiantes/' . $nombreImagen;
        }

        if ($request->filled('qrCodeData')) {
            $qrCodeData = $request->input('qrCodeData');
            $qrCodePath = $this->saveQRCodeImage($qrCodeData, 'ImagenesQREstudiantes/' . $validatedData['identificador'] . '_CodigoQR.jpg');
            $validatedData['Fotoqr'] = $qrCodePath;
        }

        $estudiante->update($validatedData);
        $this->sendQRCodeByEmail($estudiante);

        return redirect()->route('estudiantes.index')->with('flash_message', 'Registro de estudiante actualizado exitósamente!');
    }

    public function destroy($identificador): RedirectResponse
    {
        $estudiante = Estudiante::where('identificador', $identificador)->firstOrFail();
        $estudiante->delete();
        return redirect()->route('estudiantes.index')->with('flash_message', 'Registro de estudiante eliminado exitósamente!');
    }

    public function saveQRCodeImage($qrCodeData, $filePath)
    {
        // Decode the QR code image data
        $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $qrCodeData));
    
        // Save the image to the specified path
        file_put_contents(public_path($filePath), $imageData);
    
        return $filePath;
    }

    public function sendQRCodeByEmail(Estudiante $estudiante)
    {
        $email = $estudiante->email;
        $domain = substr(strrchr($email, "@"), 1);

        if ($domain === 'gmail.com' || $domain === 'googlemail.com') {
            Mail::mailer('smtp')->to($email)->send(new EstudianteQR($estudiante->Fotoqr));
        } elseif (in_array($domain, ['outlook.com', 'hotmail.com', 'live.com'])) {
            Mail::mailer('smtp_outlook')->to($email)->send(new EstudianteQR($estudiante->Fotoqr));
        } else {
            Mail::to($email)->send(new EstudianteQR($estudiante->Fotoqr));
        }
    }

    public function sendQRCode(Estudiante $estudiante)
    {
        $email = $estudiante->email;
        $domain = substr(strrchr($email, "@"), 1);

        // Determine which mailer to use based on the email domain
        if ($domain === 'gmail.com' || $domain === 'googlemail.com') {
            Mail::mailer('smtp')->to($email)->send(new EstudianteQR($estudiante->Fotoqr));
        } elseif (in_array($domain, ['outlook.com', 'hotmail.com', 'live.com'])) {
            Mail::mailer('smtp_outlook')->to($email)->send(new EstudianteQR($estudiante->Fotoqr));
        } else {
            Mail::to($email)->send(new EstudianteQR($estudiante->Fotoqr));
        }

        return redirect()->route('estudiantes.index')->with('success', 'Código QR enviado correctamente.');
    }
    
    public function importFromExcel(Request $request)
    {
        $request->validate([
            'import_file' => 'required|mimes:xlsx'
        ]);

        $file = $request->file('import_file');
        Excel::import(new EstudiantesImport, $file);

        return redirect()->route('estudiantes.index')->with('success', 'Estudiantes importados exitosamente.');
    }

    public function export()
    {
        return Excel::download(new EstudiantesExport, 'estudiantes.xlsx');
    }

    public function updatePhoto(Request $request, $identificador)
    {
        $request->validate([
            'Foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $estudiante = Estudiante::where('identificador', $identificador)->firstOrFail();

        if ($estudiante->Foto) {
            Storage::delete($estudiante->Foto);
        }

        $foto = $request->file('Foto');
        $fotoPath = 'FotosEstudiantes/Estudiante_' . $identificador . '.' . $foto->getClientOriginalExtension();
        $foto->move(public_path('FotosEstudiantes'), $fotoPath);

        $estudiante->update(['Foto' => $fotoPath]);

        return redirect()->route('estudiantes.index', $identificador)->with('flash_message', 'Foto actualizada exitósamente!');
    }

    public function updateQRCode(Request $request, $identificador)
    {
        $request->validate([
            'qrCodeData' => 'required|string',
        ]);
    
        $estudiante = Estudiante::where('identificador', $identificador)->firstOrFail();

        if ($estudiante->Fotoqr) {
            Storage::delete($estudiante->Foto);
        }

        $qrCodeData = $request->input('qrCodeData');
        $qrCodePath = $this->saveQRCodeImage($qrCodeData, 'ImagenesQREstudiantes/' . $identificador . '_CodigoQR.jpg');
    
        // Update the student's QR code path
        $estudiante->Fotoqr = $qrCodePath;
        $estudiante->save();
    
        return response()->json([
            'success' => true,
            'filePath' => asset($qrCodePath),
        ]);
    }
}