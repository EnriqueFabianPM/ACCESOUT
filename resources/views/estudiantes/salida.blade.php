@extends('estudiantes.layout')

@section('content')
<div class="row mt-4">
    <div class="col-lg-12 text-center">
        <h2>Mostrar Información de Estudiante</h2>
    </div>
    <div class="col-lg-12">
        <div class="table-responsive">
            <table class="table table-bordered table-striped mx-auto" style="width: 80%;">
                <tr>
                    <th>Identificador:</th>
                    <td>{{ $estudiante->identificador }}</td>
                </tr>
                <tr>
                    <th>Imagen de Código QR:</th>
                    <td><img src="{{ asset($estudiante->Fotoqr) }}" alt="Código QR de {{ $estudiante->nombre }}" width="100px"></td>
                </tr>
                <tr>
                    <th>Foto de Estudiante:</th>
                    <td><img src="{{ asset($estudiante->Foto) }}" alt="Foto de {{ $estudiante->nombre }}" height="100px" width="100px"></td>
                </tr>
                <tr>
                    <th>Nombre:</th>
                    <td>{{ $estudiante->nombre }}</td>
                </tr>
                <tr>
                    <th>Apellidos:</th>
                    <td>{{ $estudiante->apellidos }}</td>
                </tr>
                <tr>
                    <th>Semestre:</th>
                    <td>{{ $estudiante->semestre }}</td>
                </tr>
                <tr>
                    <th>Grupo:</th>
                    <td>{{ $estudiante->grupo }}</td>
                </tr>
                <tr>
                    <th>Email:</th>
                    <td>{{ $estudiante->email }}</td>
                </tr>
            </table>
        </div>
    </div>
    <div class="col-lg-12 text-center mt-3">
        <form action="{{ route('estudiantes.salida', $estudiante->identificador) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-primary btn-lg">Registrar Salida</button>
        </form>
    </div>
</div>
@endsection
