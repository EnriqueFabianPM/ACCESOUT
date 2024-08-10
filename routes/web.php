<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ControladorEstudiante;
use App\Http\Controllers\ControladorEmpleado;
use App\Http\Controllers\ControladorVisitante;
use App\Http\Controllers\ControladorEscaner;
use App\Http\Controllers\ControladorGuardia;
use Illuminate\Support\Facades\Auth;

// Main welcome page
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Página principal del guardia
Route::get('/InicioGuardia', function () {
    return view('InicioGuardia');
})->name('InicioGuardia');

// Authentication routes
Auth::routes();

// Route for QR code scanner page
Route::get('/scanner', [ControladorGuardia::class, 'scanner'])->name('scanner');

// Route to get IP address
Route::get('/get-ip', function () {
    return response()->json(['ip' => request()->ip()]);
});

// Route for handling QR code scans
Route::get('/scan/{qrCode}', [ControladorEscaner::class, 'handleScan'])->name('scan.handle');

// Custom Save QR Codes routes
Route::post('/estudiantes/save-qrcode', [ControladorEstudiante::class, 'saveQRCode'])->name('estudiantes.save.qrcode');
Route::post('/empleados/save-qrcode', [ControladorEmpleado::class, 'saveQRCode'])->name('empleados.save.qrcode');
Route::post('/visitantes/save-qrcode', [ControladorVisitante::class, 'saveQRCode'])->name('visitantes.save.qrcode');

// Custom Entrada and Salida routes using ControladorGuardia
Route::post('/register-entrada/{type}', [ControladorGuardia::class, 'registerEntrada'])->name('register.entrada');
Route::post('/register-salida/{type}', [ControladorGuardia::class, 'registerSalida'])->name('register.salida');

// Rutas de estudiantes
Route::get('estudiantes/entrada', [ControladorEstudiante::class, 'showEntradaForm'])->name('estudiantes.showEntradaForm');
Route::post('estudiantes/entrada/{identificador}', [ControladorEstudiante::class, 'storeEntrada'])->name('estudiantes.storeEntrada');
Route::get('estudiantes/salida', [ControladorEstudiante::class, 'showSalidaForm'])->name('estudiantes.showSalidaForm');
Route::post('estudiantes/salida/{identificador}', [ControladorEstudiante::class, 'storeSalida'])->name('estudiantes.storeSalida');
Route::resource('estudiantes', ControladorEstudiante::class)->except(['show', 'edit', 'destroy']);
Route::get('estudiantes/show/{identificador}', [ControladorEstudiante::class, 'show'])->name('estudiantes.show');
Route::get('estudiantes/edit/{identificador}', [ControladorEstudiante::class, 'edit'])->name('estudiantes.edit');
Route::delete('estudiantes/{identificador}', [ControladorEstudiante::class, 'destroy'])->name('estudiantes.destroy');
Route::get('estudiantes/import', [ControladorEstudiante::class, 'index'])->name('estudiantes.import');
Route::post('estudiantes/import', [ControladorEstudiante::class, 'importFromExcel'])->name('estudiantes.import');
Route::get('estudiantes/export/', [ControladorEstudiante::class, 'export'])->name('estudiantes.export');
Route::patch('/estudiantes/{identificador}/update-photo', [ControladorEstudiante::class, 'updatePhoto'])->name('estudiantes.updatePhoto');
Route::patch('/estudiantes/{identificador}/update-qr', [ControladorEstudiante::class, 'updateQRCode'])->name('estudiantes.updateQRCode');

// Rutas de empleados
Route::get('empleados/entrada', [ControladorEmpleado::class, 'showEntradaForm'])->name('empleados.showEntradaForm');
Route::post('empleados/entrada/{identificador}', [ControladorEmpleado::class, 'storeEntrada'])->name('empleados.storeEntrada');
Route::get('empleados/salida', [ControladorEmpleado::class, 'showSalidaForm'])->name('empleados.showSalidaForm');
Route::post('empleados/salida/{identificador}', [ControladorEmpleado::class, 'storeSalida'])->name('empleados.storeSalida');
Route::resource('empleados', ControladorEmpleado::class)->except(['show', 'edit', 'destroy']);
Route::get('empleados/show/{identificador}', [ControladorEmpleado::class, 'show'])->name('empleados.show');
Route::get('empleados/edit/{identificador}', [ControladorEmpleado::class, 'edit'])->name('empleados.edit');
Route::delete('empleados/{identificador}', [ControladorEmpleado::class, 'destroy'])->name('empleados.destroy');


// Rutas de visitantes
Route::get('visitantes/entrada', [ControladorVisitante::class, 'showEntradaForm'])->name('visitantes.showEntradaForm');
Route::post('visitantes/entrada/{identificador}', [ControladorVisitante::class, 'storeEntrada'])->name('visitantes.storeEntrada');
Route::get('visitantes/salida', [ControladorVisitante::class, 'showSalidaForm'])->name('visitantes.showSalidaForm');
Route::post('visitantes/salida/{identificador}', [ControladorVisitante::class, 'storeSalida'])->name('visitantes.storeSalida');
Route::resource('visitantes', ControladorVisitante::class)->except(['show', 'edit', 'destroy']);
Route::get('visitantes/show/{identificador}', [ControladorVisitante::class, 'show'])->name('visitantes.show');
Route::get('visitantes/edit/{identificador}', [ControladorVisitante::class, 'edit'])->name('visitantes.edit');
Route::delete('visitantes/{identificador}', [ControladorVisitante::class, 'destroy'])->name('visitantes.destroy');

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