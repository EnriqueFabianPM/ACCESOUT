<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ControladorEstudiante;
use App\Http\Controllers\ControladorEmpleado;
use App\Http\Controllers\ControladorVisitante;
use App\Http\Controllers\ControladorEscaner;
use App\Http\Controllers\ControladorGuardia;
use App\Http\Controllers\ControladorEntradasSalidas;
use Illuminate\Support\Facades\Auth;

// Main welcome page
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Authentication routes
Auth::routes();

// Route to get IP address
Route::get('/get-ip', function () {
    return response()->json(['ip' => request()->ip()]);
});

// Route for handling QR code scans
Route::get('/scan/{qrCode}', [ControladorEscaner::class, 'handleScan'])->name('scan.handle');

// Rutas del guardia de seguridad
Route::get('/guardia/inicio', function () { return view('Guardia.InicioGuardia'); })->name('InicioGuardia');
Route::get('/guardia/registrarentrada', function () { return view('Guardia.registrarentrada'); })->name('guardia.registrarentrada');
Route::get('/guardia/registrarsalida', function () { return view('Guardia.registrarsalida'); })->name('guardia.registrarsalida');
Route::get('/guardia/registrarentrada/busqueda', function () { return view('Guardia.registrarentradaidentificador'); })->name('guardia.matriculaentrada');
Route::get('/guardia/registrarsalida/busqueda', function () { return view('Guardia.registrarsalidaidentificador'); })->name('guardia.matriculasalida');
Route::get('/guardia/registrarentrada/busqueda/entrada', [ControladorEscaner::class, 'searchEntradaByIdentifier'])->name('guardia.entrar');
Route::get('/guardia/registrarsalida/busqueda/salida', [ControladorEscaner::class, 'searchSalidaByIdentifier'])->name('guardia.salir');
Route::get('/guardia/registrarentrada/scanner', function () { return view('Guardia.entradascanner'); })->name('entradascanner');
Route::get('/guardia/registrarsalida/scanner', function () { return view('Guardia.salidascanner'); })->name('salidascanner');
Route::get('/guardia/registrarvisitante', function () { return view('Guardia.registrarvisitante'); })->name('guardia.registrarvisitante');

// Rutas de estudiantes
Route::resource('estudiantes', ControladorEstudiante::class)->except(['show', 'edit', 'destroy']);
Route::get('estudiantes/show/{identificador}', [ControladorEstudiante::class, 'show'])->name('estudiantes.show');
Route::get('estudiantes/edit/{identificador}', [ControladorEstudiante::class, 'edit'])->name('estudiantes.edit');
Route::delete('estudiantes/{identificador}', [ControladorEstudiante::class, 'destroy'])->name('estudiantes.destroy');
Route::post('estudiantes/save-qrcode', [ControladorEstudiante::class, 'saveQRCodeImage'])->name('estudiantes.save.qrcode');
Route::get('estudiantes/import', [ControladorEstudiante::class, 'index'])->name('estudiantes.import');
Route::post('estudiantes/import', [ControladorEstudiante::class, 'importFromExcel'])->name('estudiantes.import');
Route::get('estudiantes/export/', [ControladorEstudiante::class, 'export'])->name('estudiantes.export');
Route::patch('estudiantes/{identificador}/update-photo', [ControladorEstudiante::class, 'updatePhoto'])->name('estudiantes.updatePhoto');
Route::patch('estudiantes/{identificador}/update-qr', [ControladorEstudiante::class, 'updateQRCode'])->name('estudiantes.updateQRCode');
Route::post('estudiantes/{estudiante}/send-qr', [ControladorEstudiante::class, 'sendQRCode'])->name('estudiantes.sendQRCode');
Route::get('estudiantes/entrada/{identificador}', [ControladorEstudiante::class, 'showEntrada'])->name('estudiantes.entrada');
Route::get('estudiantes/salida/{identificador}', [ControladorEstudiante::class, 'showSalida'])->name('estudiantes.salida');

// Rutas de empleados
Route::resource('empleados', ControladorEmpleado::class)->except(['show', 'edit', 'destroy']);
Route::get('empleados/show/{identificador}', [ControladorEmpleado::class, 'show'])->name('empleados.show');
Route::get('empleados/edit/{identificador}', [ControladorEmpleado::class, 'edit'])->name('empleados.edit');
Route::delete('empleados/{identificador}', [ControladorEmpleado::class, 'destroy'])->name('empleados.destroy');
Route::post('empleados/save-qrcode', [ControladorEmpleado::class, 'saveQRCodeImage'])->name('empleados.save.qrcode');
Route::get('empleados/import', [ControladorEmpleado::class, 'index'])->name('empleados.import');
Route::post('empleados/import', [ControladorEmpleado::class, 'importFromExcel'])->name('empleados.import');
Route::get('empleados/export/', [ControladorEmpleado::class, 'export'])->name('empleados.export');
Route::patch('empleados/{identificador}/update-photo', [ControladorEmpleado::class, 'updatePhoto'])->name('empleados.updatePhoto');
Route::patch('empleados/{identificador}/update-qr', [ControladorEmpleado::class, 'updateQRCode'])->name('empleados.updateQRCode');
Route::post('empleados/{empleado}/send-qr', [ControladorEmpleado::class, 'sendQRCode'])->name('empleados.sendQRCode');
Route::get('empleados/entrada/{identificador}', [ControladorEntradasSalidas::class, 'registrarEntrada'])->name('empleados.entrada');
Route::get('empleados/salida/{identificador}', [ControladorEntradasSalidas::class, 'registrarSalida'])->name('empleados.salida');

// Rutas de visitantes
Route::resource('visitantes', ControladorVisitante::class)->except(['show', 'edit', 'destroy']);
Route::get('visitantes/show/{identificador}', [ControladorVisitante::class, 'show'])->name('visitantes.show');
Route::get('visitantes/edit/{identificador}', [ControladorVisitante::class, 'edit'])->name('visitantes.edit');
Route::delete('visitantes/{identificador}', [ControladorVisitante::class, 'destroy'])->name('visitantes.destroy');
Route::post('visitantes/save-qrcode', [ControladorVisitante::class, 'saveQRCodeImage'])->name('visitantes.save.qrcode');
Route::get('visitantes/import', [ControladorVisitante::class, 'index'])->name('visitantes.import');
Route::post('visitantes/import', [ControladorVisitante::class, 'importFromExcel'])->name('visitantes.import');
Route::get('visitantes/export/', [ControladorVisitante::class, 'export'])->name('visitantes.export');
Route::patch('visitantes/{identificador}/update-qr', [ControladorVisitante::class, 'updateQRCode'])->name('visitantes.updateQRCode');
Route::post('visitantes/{visitante}/send-qr', [ControladorVisitante::class, 'sendQRCode'])->name('visitantes.sendQRCode');
Route::get('visitantes/entrada/{identificador}', [ControladorEntradasSalidas::class, 'registrarEntrada'])->name('visitantes.entrada');
Route::get('visitantes/salida/{identificador}', [ControladorEntradasSalidas::class, 'registrarSalida'])->name('visitantes.salida');

// Admin routes with middleware
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        if (!auth()->user()->is_admin) {
            abort(403, 'Unauthorized');
        }
        return view('admin.dashboard');
    })->name('dashboard');
    
    Route::get('/settings', function () {
        if (!auth()->user()->is_admin) {
            abort(403, 'Unauthorized');
        }
        return view('admin.settings');
    })->name('settings');
});
