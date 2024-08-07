@extends('layouts.app')

@section('title', 'Escaneo de Código QR')

@section('content')
    <div class="container mt-4">
        <center><h1>Escanear Código QR para Entrar a la Universidad</h1></center>
        <div class="form-group mt-5">
            <label for="qrInput">Coloque el cursor en el campo de abajo y escanee el Código QR:</label>
            <input type="text" id="qrInput" class="form-control" autofocus>
        </div>
        <p id="loadingMessage" class="text-center mt-3">Iniciando escáner de QR...</p>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const qrInput = document.getElementById('qrInput');
            let scanTimeout;

            qrInput.addEventListener('input', function () {
                clearTimeout(scanTimeout);

                scanTimeout = setTimeout(function() {
                    let scannedData = qrInput.value.trim();
                    console.log('Scanned Data:', scannedData); // For debugging purposes

                    // Ensure the scanned data is in the format expected by the backend
                    scannedData = scannedData
                        .replace(/[^a-zA-Z0-9:_-]/g, '') // Remove unwanted characters
                        .trim();

                    console.log('Processed Data:', scannedData); // For debugging purposes

                    if (scannedData) {
                        // Construct the URL to handle the scan
                        const url = `{{ route('scanner', ['qrCode' => '']) }}${encodeURIComponent(scannedData)}`;
                        window.location.href = url;
                    } else {
                        alert('Error: Código QR inválido, por favor ingrese nuevamente.');
                        qrInput.value = '';
                    }
                }, 500); // Delay to ensure the full QR code is captured
            });
        });
    </script>
@endsection
