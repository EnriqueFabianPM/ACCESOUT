<?php

namespace App\Http\Controllers;

use App\Exports\EstudiantesExport;
use App\Models\Estudiante;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Mail;
use App\Mail\EstudianteQR;
use Illuminate\Support\Facades\Log;
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
            'apellidos' => 'required|string|max:255',
            'semestre' => 'required|string|max:255',
            'grupo' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:estudiantes',
        ]);

        if ($request->hasFile('Foto')) {
            $imagen = $request->file('Foto');
            $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
            $rutaImagen = $imagen->move(public_path('FotosEstudiantes'), $nombreImagen);
            $validatedData['Foto'] = 'FotosEstudiantes/' . $nombreImagen;
        }

        if ($request->filled('qrCodeData')) {
            $qrCodeData = $request->input('qrCodeData');
            $qrCodePath = $this->saveQRCode($qrCodeData);
            $validatedData['Fotoqr'] = $qrCodePath;
        }

        $estudiante = Estudiante::create($validatedData);
        $this->sendQRCodeByEmail($estudiante);

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
            'apellidos' => 'required|string|max:255',
            'semestre' => 'required|string|max:255',
            'grupo' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:estudiantes,email,' . $estudiante->id,
        ]);

        if ($request->hasFile('Foto')) {
            $imagen = $request->file('Foto');
            $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
            $rutaImagen = $imagen->move(public_path('FotosEstudiantes'), $nombreImagen);
            $validatedData['Foto'] = 'FotosEstudiantes/' . $nombreImagen;
        }

        if ($request->filled('qrCodeData')) {
            $qrCodeData = $request->input('qrCodeData');
            $qrCodePath = $this->saveQRCode($qrCodeData);
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

    public function saveQRCode($qrCodeData)
    {
        $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $qrCodeData));
        $qrCodePath = 'ImagenesQREstudiantes/' . time() . '_qrcode.jpg';
        file_put_contents(public_path($qrCodePath), $imageData);

        return $qrCodePath;
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

    public function importFromExcel(Request $request)
    {
        $request->validate([
            'import_file' => 'required|mimes:xlsx'
        ]);

        $file = $request->file('import_file');
        Excel::import(new EstudiantesImport, $file);

        return redirect()->route('estudiantes.index')->with('success', 'Estudiantes importados exitosamente.');
    }

    public function showMultipleCreateForm(): View
    {
        // Show a form to upload a file for multiple student creation
        return view('estudiantes.multiplecreate');
    }

    public function storeMultiple(Request $request)
    {
        $data = $request->all();
    
        // Validate the data
        $validatedData = $request->validate([
            'identificadores.*' => 'required|string',
            'nombres.*' => 'required|string',
            'apellidos.*' => 'nullable|string',
            'semestres.*' => 'nullable|string',
            'grupos.*' => 'nullable|string',
            'emails.*' => 'nullable|email',
            'qrCodeData.*' => 'nullable|string',
            'Fotos.*' => 'nullable|file|mimes:jpg,jpeg,png',
        ]);
    
        foreach ($validatedData['identificadores'] as $index => $identificador) {
            $studentData = [
                'identificador' => $identificador,
                'nombre' => $validatedData['nombres'][$index],
                'apellidos' => $validatedData['apellidos'][$index] ?? null,
                'semestre' => $validatedData['semestres'][$index] ?? null,
                'grupo' => $validatedData['grupos'][$index] ?? null,
                'email' => $validatedData['emails'][$index] ?? null,
                'Fotoqr' => $validatedData['qrCodeData'][$index] ?? null,
            ];
    
            if (isset($request->file('Fotos')[$index])) {
                $photo = $request->file('Fotos')[$index];
                $photoPath = $photo->store('FotosEstudiantes', 'public');
                $studentData['Foto'] = $photoPath;
            }
    
            Estudiante::updateOrCreate(
                ['identificador' => $studentData['identificador']],
                $studentData
            );
        }
    
        return redirect()->route('estudiantes.index')->with('success', 'Estudiantes registrados exitosamente.');
    }
    
    public function export() 
    {
        return Excel::download(new EstudiantesExport, 'users.xlsx');
    }
    
}