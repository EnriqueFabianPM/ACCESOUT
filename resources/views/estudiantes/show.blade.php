@extends('estudiantes.layout')

@section('content')
<div class="row">
    <div class="col-lg-6">
        <h2>Mostrar Información de Estudiante</h2>
    </div>
    <div class="col-lg-6 text-end">
        <a class="btn btn-primary" href="{{ route('estudiantes.index') }}">Volver al Registro</a>
    </div>
</div>

<div class="row mt-4">
    <div class="col-lg-6">
        <table class="table table-bordered table-striped">
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
@endsection