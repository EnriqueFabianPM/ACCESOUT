@extends('empleados.layout')

@section('content')
<div class="row mt-4">
    <div class="col-lg-12 text-center">
        <h2>Mostrar Información de Empleado</h2>
    </div>
    <div class="col-lg-12">
        <div class="table-responsive">
        <table class="table table-bordered table-striped mx-auto" style="width: 80%;">
            <tr>
                <th>Identificador:</th>
                <td>{{ $empleado->identificador }}</td>
            </tr>
            <tr>
                <th>Imagen de Código QR:</th>
                <td><img src="{{ asset($empleado->Fotoqr) }}" width="100px"></td>
            </tr>
            <tr>
                <th>Foto de Empleado:</th>
                <td><img src="{{ asset($empleado->Foto) }}" height="100px" width="100px"></td>
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
                <th>Área de Trabajo:</th>
                <td>{{ $empleado->areatrabajo }}</td>
            </tr>
            <tr>
                <th>Teléfono:</th>
                <td>{{ $empleado->telefono }}</td>
            </tr>
            <tr>
                <th>Email:</th>
                <td>{{ $empleado->email }}</td>
            </tr>
        </table>
    </div>
    <div class="col-lg-12 text-center mt-3">
        <form action="{{ route('empleados.registerentrada', $empleado->identificador) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="caseta">Selecciona la caseta:</label>
                <select name="caseta" id="caseta" class="form-control">
                    <option value="peatonal">Peatonal</option>
                    <option value="vehicular">Vehicular</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary btn-lg">Registrar Entrada</button>
        </form>
    </div>
</div>
@endsection
