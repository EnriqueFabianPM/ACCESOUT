@extends('empleados.layout')

@section('content')
<div class="row">
    <div class="col-lg-6">
        <h2>Registrar Salida de Empleado</h2>
    </div>
    <div class="col-lg-6 text-end">
        <a class="btn btn-primary" href="{{ route('empleados.index') }}">Volver al Registro</a>
    </div>
</div>

<div class="row mt-4">
    <div class="col-lg-6">
        <table class="table table-bordered table-striped">
            <tr>
                <th>Identificador:</th>
                <td>{{ $empleado->identificador }}</td>
            </tr>
            <tr>
                <th>Foto del Empleado:</th>
                <td>
                    @if($empleado->Foto)
                        <img src="{{ asset($empleado->Foto) }}" height="100px" width="100px">
                    @else
                        No disponible
                    @endif
                </td>
            </tr>
            <tr>
                <th>Nombre:</th>
                <td>{{ $empleado->nombre }}</td>
            </tr>
            <tr>
                <th>Apellidos:</th>
                <td>{{ $empleado->apellidos }}</td>
            </tr>
            <tr>
                <th>Area de Trabajo:</th>
                <td>{{ $empleado->areatrabajo }}</td>
            </tr>
            <tr>
                <th>Telefono:</th>
                <td>{{ $empleado->telefono }}</td>
            </tr>
            <tr>
                <th>Email:</th>
                <td>{{ $empleado->email }}</td>
            </tr>
            <tr>
                <th>Entrada:</th>
                <td>{{ $empleado->entrada }}</td>
            </tr>
            <tr>
                <th>Salida:</th>
                <td>{{ $empleado->salida }}</td>
            </tr>
        </table>
    </div>
</div>

<form action="{{ route('empleados.registrarSalida', $empleado->id) }}" method="post">
    @csrf
    <div class="form-group">
        <label for="salida">Registrar Salida:</label>
        <input type="datetime-local" class="form-control" id="salida" name="salida" required>
    </div>
    <button type="submit" class="btn btn-success">Registrar Salida</button>
</form>
@endsection
