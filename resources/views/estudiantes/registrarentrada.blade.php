@extends('estudiantes.layout')

@section('content')
<div class="row">
    <div class="col-lg-6">
        <h2>Registrar Entrada de Estudiante</h2>
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
                <th>Foto del Estudiante:</th>
                <td>
                    @if($estudiante->Foto)
                        <img src="{{ asset('storage/' . $estudiante->Foto) }}" height="100px" width="100px" alt="Foto del Estudiante">
                    @else
                        No disponible
                    @endif
                </td>
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
            <tr>
                <th>Entrada:</th>
                <td>{{ $estudiante->entrada ? $estudiante->entrada->format('Y-m-d H:i') : 'No registrada' }}</td>
            </tr>
            <tr>
                <th>Salida:</th>
                <td>{{ $estudiante->salida ? $estudiante->salida->format('Y-m-d H:i') : 'No registrada' }}</td>
            </tr>
        </table>
    </div>
</div>

<form action="{{ route('estudiantes.registrarEntrada', $estudiante->id) }}" method="post">
    @csrf
    <div class="form-group">
        <label for="entrada">Registrar Entrada:</label>
        <input type="datetime-local" class="form-control" id="entrada" name="entrada" required>
    </div>
    <button type="submit" class="btn btn-success">Registrar Entrada</button>
</form>
@endsection
