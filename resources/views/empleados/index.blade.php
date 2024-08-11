@extends('empleados.layout')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2>Sistema de Registro de Empleados UTSC</h2>
                    <center><a href="{{ route('home') }}" style="background-color: #010201; padding: 10px;" class="btn btn-primary btn-lg mr-3">Volver al Inicio</a></center>
                </div>
                <div class="card-body">
                    <a href="{{ route('empleados.create') }}" class="btn btn-success btn-sm mb-3"
                        title="Registrar Nuevo Empleado">
                        <i class="fa fa-plus" aria-hidden="true"></i> Registrar Nuevo Empleado
                    </a>

                    <form action="{{ route('empleados.import') }}" method="POST" enctype="multipart/form-data" class="mb-3">
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
                                    <th>Area de Trabajo</th>
                                    <th>Telefono</th>
                                    <th>Email</th>
                                    <th>Entrada</th>
                                    <th>Salida</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($empleados as $empleado)
                                <tr>
                                    <td>{{ $empleado->identificador }}</td>
                                    <td>
                                        @if($empleado->Fotoqr)
                                            <img src="{{ asset($empleado->Fotoqr) }}" alt="QR Code" width="100px">
                                            <form action="{{ route('empleados.sendQRCode', $empleado) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-primary">Enviar Código QR</button>
                                            </form>
                                        @else
                                            <form action="{{ route('empleados.updateQRCode', $empleado->identificador) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PATCH')
                                                <button type="button" class="btn btn-primary btn-sm" onclick="generateAndUploadQR('{{ $empleado->identificador }}', this)">Generar Código QR</button>
                                            </form>
                                        @endif
                                    </td>
                                    <td>
                                        @if($empleado->Foto)
                                            <img src="{{ asset($empleado->Foto) }}" width="100px" alt="Foto">
                                        @else
                                            <form action="{{ route('empleados.updatePhoto', $empleado->identificador) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PATCH')
                                                <input type="file" class="form-control-file" id="Foto" name="Foto" required>
                                                <button type="submit" class="btn btn-primary btn-sm mt-2">Subir Foto</button>
                                            </form>
                                        @endif
                                    </td>
                                    <td>{{ $empleado->nombre }}</td>
                                    <td>{{ $empleado->apellidos }}</td>
                                    <td>{{ $empleado->areatrabajo }}</td>
                                    <td>{{ $empleado->telefono }}</td>
                                    <td>{{ $empleado->email }}</td>
                                    <td>{{ $empleado->entrada }}</td>
                                    <td>{{ $empleado->salida }}</td>
                                    <td>
                                        <a href="{{ route('empleados.show', $empleado->identificador) }}"
                                            class="btn btn-info btn-sm" title="Ver Empleado">
                                            <i class="fa fa-eye" aria-hidden="true"></i> Ver
                                        </a>
                                        <a href="{{ route('empleados.edit', $empleado->identificador) }}"
                                            class="btn btn-primary btn-sm" title="Editar Empleado">
                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar
                                        </a>

                                        <form method="POST"
                                            action="{{ route('empleados.destroy', $empleado->identificador) }}"
                                            accept-charset="UTF-8" style="display: inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                title="Eliminar Empleado"
                                                onclick="return confirm('¿Estás seguro de que quieres eliminar este empleado?')">
                                                <i class="fa fa-trash-o" aria-hidden="true"></i> Eliminar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="12" class="text-center">No hay empleados registrados.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{ $empleados->links() }} <!-- Agregar paginación si es necesario -->
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/qrcode-generator/qrcode.js"></script>
<script>
    function generateAndUploadQR(identificador, button) {
        const baseURL = window.location.origin;
        const url = `${baseURL}/empleados/${identificador}/update-qr`;
        const redirectURL = `${baseURL}/empleados/show/${identificador}`;
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