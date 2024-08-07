<?php

namespace App\Http\Controllers;

use App\Models\Visitante;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Mail;
use App\Mail\VisitanteQR;

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
            'entrada' => 'nullable|date',
            'salida' => 'nullable|date',
        ]);

        // Create visitante record
        $visitante = Visitante::create($validatedData);

        // Save QR code if provided
        if ($request->filled('qrCodeData')) {
            $qrCodeData = $request->input('qrCodeData');
            $qrCodePath = $this->saveQRCode($qrCodeData);
            $visitante->update(['Fotoqr' => $qrCodePath]);
        }

        // Send email with QR code attached
        $this->sendQRCodeByEmail($visitante);

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
            'entrada' => 'nullable|date',
            'salida' => 'nullable|date',
        ]);

        // Update visitante record
        $visitante->update($validatedData);

        // Save QR code if provided
        if ($request->filled('qrCodeData')) {
            $qrCodeData = $request->input('qrCodeData');
            $qrCodePath = $this->saveQRCode($qrCodeData);
            $visitante->update(['Fotoqr' => $qrCodePath]);
        }

        // Send email with QR code attached
        $this->sendQRCodeByEmail($visitante);

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
    private function saveQRCode($qrCodeData)
    {
        $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $qrCodeData));
        $qrCodePath = 'ImagenesQRVisitantes/' . time() . '_qrcode.jpg';
        file_put_contents(public_path($qrCodePath), $imageData);

        return $qrCodePath;
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
}