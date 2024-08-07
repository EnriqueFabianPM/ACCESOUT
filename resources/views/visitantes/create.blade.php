@extends('visitantes.layout')

@section('content')
<div class="card">
    <div class="card-header">Registrar Nuevo Visitante</div>
    <div class="card-body">
        <form id="visitanteForm" action="{{ route('visitantes.store') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="identificador">Identificador: <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="identificador" name="identificador" required>
            </div>
            <div class="form-group">
                <label for="nombre">Nombre: <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="apellidos">Apellidos: <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="apellidos" name="apellidos" required>
            </div>
            <div class="form-group">
                <label for="motivo">Motivo de Visita: <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="motivo" name="motivo" required>
            </div>
            <div class="form-group">
                <label for="telefono">Telefono: <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="telefono" name="telefono" required>
            </div>
            <div class="form-group">
                <label for="email">E-mail: <span class="text-danger">*</span></label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="entrada">Entrada</label>
                <input type="date" class="form-control" id="entrada" name="entrada">
            </div>
            <div class="form-group">
                <label for="salida">Salida</label>
                <input type="date" class="form-control" id="salida" name="salida">
            </div>
            <div class="form-group">
                <h3>Generar Código QR</h3>
                <button type="button" id="generateQR" class="btn btn-primary">Generar QR Code</button>
            </div>
            <!-- QR Code Display Area -->
            <div id="qrCodeDisplay" class="mb-3"></div>            
            <input type="hidden" name="qrCodeData" id="qrCodeData">
            
            <button type="submit" class="btn btn-success">Registrar</button>
        </form>
    </div>
</div>

<!-- Include qrcode-generator library -->
<script src="https://cdn.jsdelivr.net/npm/qrcode-generator/qrcode.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const generateQR = document.getElementById('generateQR');
    const qrCodeDisplay = document.getElementById('qrCodeDisplay');
    const qrCodeDataInput = document.getElementById('qrCodeData');

    fetch('/get-ip')
        .then(response => response.json())
        .then(data => {
            const ip = data.ip;

            generateQR.addEventListener('click', function() {
                const identificadorValue = document.getElementById('identificador').value;

                if (identificadorValue) {
                    const baseURL = `http://${ip}:8000`; // Dynamically set IP address
                    const redirectURL = `${baseURL}/visitantes/show/${identificadorValue}`;
                    console.log('Redirect URL:', redirectURL);

                    const typeNumber = 4;
                    const errorCorrectionLevel = 'L';
                    const qr = qrcode(typeNumber, errorCorrectionLevel);
                    qr.addData(redirectURL);
                    qr.make();

                    qrCodeDisplay.innerHTML = qr.createImgTag(10);

                    qrCodeDataInput.value = qr.createDataURL(10);
                } else {
                    alert('Please enter the identifier before generating QR code.');
                }
            });
        });
});
</script>
@endsection
