<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Exports\VisitantesExport;
use App\Models\Visitante;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Mail;
use App\Mail\VisitanteQR;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\VisitantesImport;

class ControladorVisitante extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $visitantes = Visitante::paginate(10);
        return view('visitantes.index', compact('visitantes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('visitantes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'identificador' => 'required|string|max:255',
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'motivo' => 'required|string|max:255',
            'telefono' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:visitantes',
        ]);

        if ($request->filled('qrCodeData')) {
            $qrCodeData = $request->input('qrCodeData');
            $qrCodePath = $this->saveQRCodeImage($qrCodeData, 'ImagenesQRVisitantes/' . $validatedData['identificador'] . '_CodigoQR.jpg');
            $validatedData['Fotoqr'] = $qrCodePath;
        }

        Visitante::create($validatedData);
        $this->sendQRCodeByEmail(Visitante::where('identificador', $validatedData['identificador'])->first());

        return redirect()->route('visitantes.index')->with('flash_message', 'Visitante dado de alta exitosamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show($identificador): View
    {
        $visitante = Visitante::where('identificador', $identificador)->firstOrFail();
        return view('visitantes.show', compact('visitante'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($identificador): View
    {
        $visitante = Visitante::where('identificador', $identificador)->firstOrFail();
        return view('visitantes.edit', compact('visitante'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Visitante $visitante): RedirectResponse
    {
        $validatedData = $request->validate([
            'identificador' => 'required|string|max:255',
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'motivo' => 'required|string|max:255',
            'telefono' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:visitantes,email,' . $visitante->id,
        ]);

        if ($request->filled('qrCodeData')) {
            $qrCodeData = $request->input('qrCodeData');
            $qrCodePath = $this->saveQRCodeImage($qrCodeData, 'ImagenesQRVisitantes/' . $validatedData['identificador'] . '_CodigoQR.jpg');
            $validatedData['Fotoqr'] = $qrCodePath;
        }

        $visitante->update($validatedData);
        $this->sendQRCodeByEmail(Visitante::where('identificador', $validatedData['identificador'])->first());

        return redirect()->route('visitantes.index')->with('flash_message', 'Registro de visitante actualizado exitosamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($identificador): RedirectResponse
    {
        $visitante = Visitante::where('identificador', $identificador)->firstOrFail();
        $visitante->delete();
        return redirect()->route('visitantes.index')->with('flash_message', 'Registro de visitante eliminado exitosamente!');
    }

    /**
     * Save QR code image to public directory.
     */
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
    private function sendQRCodeByEmail(Visitante $visitante)
    {
        $email = $visitante->email;
        $domain = substr(strrchr($email, "@"), 1);

        if ($domain === 'gmail.com' || $domain === 'googlemail.com') {
            Mail::mailer('smtp')->to($email)->send(new VisitanteQR($visitante->Fotoqr));
        } elseif (in_array($domain, ['outlook.com', 'hotmail.com', 'live.com'])) {
            Mail::mailer('smtp_outlook')->to($email)->send(new VisitanteQR($visitante->Fotoqr));
        } else {
            Mail::to($email)->send(new VisitanteQR($visitante->Fotoqr));
        }
    }

    public function sendQRCode(Visitante $visitante)
    {
        $email = $visitante->email;
        $domain = substr(strrchr($email, "@"), 1);

        // Determine which mailer to use based on the email domain
        if ($domain === 'gmail.com' || $domain === 'googlemail.com') {
            Mail::mailer('smtp')->to($email)->send(new VisitanteQR($visitante->Fotoqr));
        } elseif (in_array($domain, ['outlook.com', 'hotmail.com', 'live.com'])) {
            Mail::mailer('smtp_outlook')->to($email)->send(new VisitanteQR($visitante->Fotoqr));
        } else {
            Mail::to($email)->send(new VisitanteQR($visitante->Fotoqr));
        }

        return redirect()->route('visitantes.index')->with('success', 'Código QR enviado correctamente.');
    }
    
    public function importFromExcel(Request $request)
    {
        $request->validate([
            'import_file' => 'required|mimes:xlsx'
        ]);

        $file = $request->file('import_file');
        Excel::import(new VisitantesImport, $file);

        return redirect()->route('visitantes.index')->with('success', 'Visitantes importados exitosamente.');
    }

    public function export()
    {
        return Excel::download(new VisitantesExport, 'visitantes.xlsx');
    }

    public function updateQRCode(Request $request, $identificador)
    {
        $request->validate([
            'qrCodeData' => 'required|string',
        ]);
    
        $visitante = Visitante::where('identificador', $identificador)->firstOrFail();

        if ($visitante->Fotoqr) {
            Storage::delete($visitante->Fotoqr);
        }

        $qrCodeData = $request->input('qrCodeData');
        $qrCodePath = $this->saveQRCodeImage($qrCodeData, 'ImagenesQRVisitantes/' . $identificador . '_CodigoQR.jpg');
    
        // Update the student's QR code path
        $visitante->Fotoqr = $qrCodePath;
        $visitante->save();
    
        return response()->json([
            'success' => true,
            'filePath' => asset($qrCodePath),
        ]);
    }
}