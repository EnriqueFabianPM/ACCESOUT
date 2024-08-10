@extends('estudiantes.layout')

@section('content')
<div class="card">
    <!-- Student Registration Form -->
    <div class="card-header">Registrar Nuevo Estudiante</div>
    <div class="card-body">
        <form id="estudianteForm" action="{{ route('estudiantes.store') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="Foto">Foto del Estudiante</label>
                <input type="file" class="form-control-file" id="Foto" name="Foto">
            </div>

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
                <label for="semestre">Semestre: <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="semestre" name="semestre" required>
            </div>

            <div class="form-group">
                <label for="grupo">Grupo: <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="grupo" name="grupo" required>
            </div>

            <div class="form-group">
                <label for="email">E-mail: <span class="text-danger">*</span></label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>

            <div class="form-group">
                <h1>Código QR</h1>
                <button type="button" id="generateQR" class="btn btn-primary">Generar QR Code</button>
            </div>
            <!-- QR Code Display Area -->
            <div id="qrCodeDisplay" class="mb-3"></div>
            <input type="hidden" name="qrCodeData" id="qrCodeData">

            <button type="submit" class="btn btn-success">Registrar Estudiante</button>
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
    const identificadorInput = document.getElementById('identificador');

    function updateButtonState() {
        generateQR.disabled = !identificadorInput.value.trim();
    }

    identificadorInput.addEventListener('input', updateButtonState);

    generateQR.addEventListener('click', function() {
        const identificadorValue = identificadorInput.value;

        if (identificadorValue) {
            const baseURL = window.location.origin; // Use the current domain
            const redirectURL = `${baseURL}/estudiantes/show/${identificadorValue}`;
            console.log('Redirect URL:', redirectURL);

            const typeNumber = 4;
            const errorCorrectionLevel = 'L';
            const qr = qrcode(typeNumber, errorCorrectionLevel);
            qr.addData(redirectURL);
            qr.make();

            qrCodeDisplay.innerHTML = qr.createImgTag(10);

            qrCodeDataInput.value = qr.createDataURL(10);
        } else {
            alert('Por favor, ingresa el identificador antes de generar el código QR.');
        }
    });
});
</script>
@endsection
