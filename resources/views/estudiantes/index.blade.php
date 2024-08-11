@extends('estudiantes.layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-center">
                    <h2>Sistema de Registro de Estudiantes UTSC</h2>
                    <a href="{{ route('home') }}" class="btn btn-primary btn-lg mt-3">
                        Volver al Inicio
                    </a>
                </div>
                <div class="card-body">
                    <a href="{{ route('estudiantes.create') }}" class="btn btn-success btn-sm mb-3" title="Registrar Nuevo Estudiante">
                        <i class="fa fa-plus" aria-hidden="true"></i> Registrar Nuevo Estudiante
                    </a>

                    <form action="{{ route('estudiantes.import') }}" method="POST" enctype="multipart/form-data" class="mb-3">
                        @csrf
                        <div class="form-group">
                            <label for="import_file">Subir archivo Excel (.xlsx)</label>
                            <input type="file" name="import_file" id="import_file" accept=".xlsx" class="form-control">
                            @error('import_file')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Subir</button>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Identificador</th>
                                    <th>Código QR</th>
                                    <th>Foto</th>
                                    <th>Nombre</th>
                                    <th>Apellidos</th>
                                    <th>Semestre</th>
                                    <th>Grupo</th>
                                    <th>Email</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($estudiantes as $estudiante)
                                <tr>
                                    <td>{{ $estudiante->identificador }}</td>
                                    <td>
                                        @if($estudiante->Fotoqr)
                                            <img src="{{ asset($estudiante->Fotoqr) }}" alt="QR Code" width="100px">
                                            <form action="{{ route('estudiantes.sendQRCode', $estudiante) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-primary">Enviar Código QR</button>
                                            </form>
                                        @else
                                            <form action="{{ route('estudiantes.updateQRCode', $estudiante->identificador) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PATCH')
                                                <button type="button" class="btn btn-primary btn-sm" onclick="generateAndUploadQR('{{ $estudiante->identificador }}', this)">Generar Código QR</button>
                                            </form>
                                        @endif
                                    </td>
                                    <td>
                                        @if($estudiante->Foto)
                                            <img src="{{ asset($estudiante->Foto) }}" width="100px" alt="Foto">
                                        @else
                                            <form action="{{ route('estudiantes.updatePhoto', $estudiante->identificador) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PATCH')
                                                <input type="file" class="form-control-file" id="Foto" name="Foto" required>
                                                <button type="submit" class="btn btn-primary btn-sm mt-2">Subir Foto</button>
                                            </form>
                                        @endif
                                    </td>
                                    <td>{{ $estudiante->nombre }}</td>
                                    <td>{{ $estudiante->apellidos }}</td>
                                    <td>{{ $estudiante->semestre }}</td>
                                    <td>{{ $estudiante->grupo }}</td>
                                    <td>{{ $estudiante->email }}</td>
                                    <td>
                                        <a href="{{ route('estudiantes.show', $estudiante->identificador) }}" class="btn btn-info btn-sm" title="Ver Estudiante">
                                            <i class="fa fa-eye" aria-hidden="true"></i> Ver
                                        </a>
                                        <a href="{{ route('estudiantes.edit', $estudiante->identificador) }}" class="btn btn-primary btn-sm" title="Editar Estudiante">
                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar
                                        </a>
                                        <form method="POST" action="{{ route('estudiantes.destroy', $estudiante->identificador) }}" style="display:inline;" onsubmit="return confirm('¿Confirmar eliminar?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Eliminar Estudiante">
                                                <i class="fa fa-trash-o" aria-hidden="true"></i> Eliminar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center">No hay estudiantes registrados</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="pagination-wrapper"> {!! $estudiantes->links() !!} </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/qrcode-generator/qrcode.js"></script>
<script>
    function generateAndUploadQR(identificador, button) {
        const baseURL = window.location.origin;
        const url = `${baseURL}/estudiantes/${identificador}/update-qr`;
        const redirectURL = `${baseURL}/estudiantes/show/${identificador}`;
        const typeNumber = 4;
        const errorCorrectionLevel = 'L';
        const qr = qrcode(typeNumber, errorCorrectionLevel);
        qr.addData(redirectURL);
        qr.make();

        const qrCodeDataURL = qr.createDataURL();

        // Display QR code temporarily
        const td = button.closest('td');
        td.innerHTML = `<img src="${qrCodeDataURL}" alt="QR Code" width="100px">`;

        // Send the QR code data to the server
        fetch(url, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ qrCodeData: qrCodeDataURL })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update the table cell with the newly saved QR code
                td.innerHTML = `<img src="${data.filePath}" alt="QR Code" width="100px">`;
            } else {
                alert('Error al actualizar el código QR.');
            }
        })
        .catch(error => console.error('Error:', error));
    }
</script>
@endsection