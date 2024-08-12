@extends('layouts.app')

@section('title', 'Escaneo de Codigo QR')

@section('content')
    <div class="container mt-4">
        <center><h1>Escanear Código QR para salir de la universidad</h1></center>
        <p id="loadingMessage" class="text-center mt-3">Aumente el brillo y haga zoom para escanear más fácilmente</p>
        <div class="form-group mt-5">
            <label for="qrInput">Coloque el cursor en el campo de abajo y escanee el Código QR:</label>
            <input type="text" id="qrInput" class="form-control" autofocus>
        </div>
        <!-- Buttons for other actions -->
        <div class="btn-group mt-4" role="group" aria-label="Acciones del Guardia">
            <a href="{{ route('guardia.registrarsalida') }}" class="btn btn-primary btn-lg">Volver a registro de salida</a>
            <a href="{{ route('InicioGuardia') }}" class="btn btn-secondary btn-lg">Volver a Inicio</a>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const qrInput = document.getElementById('qrInput');
        let scanTimeout;

        qrInput.addEventListener('input', function () {
            clearTimeout(scanTimeout);

            scanTimeout = setTimeout(function() {
                let scannedData = qrInput.value.trim();
                console.log('Scanned Data:', scannedData);

                // Normalize the scanned data
                scannedData = scannedData
                    .replace(/>/g, ':')
                    .replace(/&/g, '/')
                    .replace(/^http:\/\//, 'http://')
                    .replace(/^http>/, 'http://')
                    .replace(/^http>&&/, 'http://');

                console.log('Processed Data:', scannedData);

                // Extract the relevant part of the URL (e.g., estudiantes/show/21024)
                let urlParts = scannedData.split('/');
                let routeType = urlParts[urlParts.length - 3]; // "estudiantes", "empleados", or "visitantes"
                let identificador = urlParts[urlParts.length - 1]; // The identifier, e.g., "21024"

                if (routeType && identificador) {
                    // Redirect to the entrada or salida route based on the context
                    window.location.href = `/${routeType}/salida/${identificador}`;
                } else {
                    alert('Error: Código QR inválido, por favor ingrese nuevamente.');
                    qrInput.value = '';
                }
            }, 500); // Delay to ensure the full QR code is captured
        });
    });
</script>

@endsection
