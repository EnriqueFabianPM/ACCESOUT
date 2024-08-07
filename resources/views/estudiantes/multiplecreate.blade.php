@extends('estudiantes.layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-center">
                    <a href="{{ route('home') }}" class="btn btn-primary btn-lg mt-3" style="background-color: #010201; padding: 10px;">
                        Volver al Inicio
                    </a>
                    <h2>Registrar Varios Estudiantes</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('estudiantes.multiplecreate') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <!-- Dynamic student forms -->
                        @for ($i = 0; $i < 3; $i++)
                        <div class="card mb-3">
                            <div class="card-header">
                                <h4>Registro para Estudiante #{{ $i + 1 }}</h4>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="Foto{{ $i }}">Foto del Estudiante #{{ $i + 1 }}</label>
                                    <input type="file" class="form-control-file" id="Foto{{ $i }}" name="Fotos[{{ $i }}]">
                                </div>
                    
                                <div class="form-group">
                                    <label for="identificador{{ $i }}">Identificador de :</label>
                                    <input type="text" class="form-control" id="identificador{{ $i }}" name="identificadores[]" value="{{ old('identificadores.' . $i) }}">
                                </div>
                    
                                <div class="form-group">
                                    <label for="nombre{{ $i }}">Nombre:</label>
                                    <input type="text" class="form-control" id="nombre{{ $i }}" name="nombres[]" value="{{ old('nombres.' . $i) }}">
                                </div>
                    
                                <div class="form-group">
                                    <label for="apellidos{{ $i }}">Apellidos:</label>
                                    <input type="text" class="form-control" id="apellidos{{ $i }}" name="apellidos[]" value="{{ old('apellidos.' . $i) }}">
                                </div>
                    
                                <div class="form-group">
                                    <label for="semestre{{ $i }}">Semestre:</label>
                                    <input type="text" class="form-control" id="semestre{{ $i }}" name="semestres[]" value="{{ old('semestres.' . $i) }}">
                                </div>
                    
                                <div class="form-group">
                                    <label for="grupo{{ $i }}">Grupo:</label>
                                    <input type="text" class="form-control" id="grupo{{ $i }}" name="grupos[]" value="{{ old('grupos.' . $i) }}">
                                </div>
                    
                                <div class="form-group">
                                    <label for="email{{ $i }}">E-mail:</label>
                                    <input type="email" class="form-control" id="email{{ $i }}" name="emails[]" value="{{ old('emails.' . $i) }}">
                                </div>
                    
                                <div class="form-group">
                                    <h1>Código QR</h1>
                                    <button type="button" id="generateQR{{ $i }}" class="btn btn-primary">Generar QR Code</button>
                                </div>
                                <div id="qrCodeDisplay{{ $i }}" class="mb-3"></div>
                                <input type="hidden" name="qrCodeData[{{ $i }}]" id="qrCodeData{{ $i }}">
                    
                            </div>
                        </div>
                        @endfor
                    
                        <button type="submit" class="btn btn-success">Registrar Todos</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include qrcode-generator library -->
<script src="https://cdn.jsdelivr.net/npm/qrcode-generator/qrcode.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    @for ($i = 0; $i < 3; $i++)
    const generateQR{{ $i }} = document.getElementById('generateQR{{ $i }}');
    const qrCodeDisplay{{ $i }} = document.getElementById('qrCodeDisplay{{ $i }}');
    const qrCodeDataInput{{ $i }} = document.getElementById('qrCodeData{{ $i }}');
    const identificadorInput{{ $i }} = document.getElementById('identificador{{ $i }}');

    function updateButtonState() {
        generateQR{{ $i }}.disabled = !identificadorInput{{ $i }}.value.trim();
    }

    identificadorInput{{ $i }}.addEventListener('input', updateButtonState);

    generateQR{{ $i }}.addEventListener('click', function() {
        const identificadorValue = identificadorInput{{ $i }}.value;

        if (identificadorValue) {
            const baseURL = window.location.origin; // Use the current domain
            const redirectURL = `${baseURL}/estudiantes/show/${identificadorValue}`;
            console.log('Redirect URL:', redirectURL);

            const typeNumber = 4;
            const errorCorrectionLevel = 'L';
            const qr = qrcode(typeNumber, errorCorrectionLevel);
            qr.addData(redirectURL);
            qr.make();

            qrCodeDisplay{{ $i }}.innerHTML = qr.createImgTag(10);

            qrCodeDataInput{{ $i }}.value = qr.createDataURL(10);
        } else {
            alert('Por favor, ingresa el identificador antes de generar el código QR.');
        }
    });
    @endfor
});
</script>
@endsection
