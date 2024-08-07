@extends('empleados.layout')
@section('content')
<div class="card">
    <div class="card-header">Registrar Salida de Empleado</div>
    <div class="card-body">
        <form action="{{ route('empleados.storeSalida', $empleado->id) }}" method="post">
            @csrf
            <div class="form-group">
                <label for="identificador">Identificador:</label>
                <input type="text" class="form-control" id="identificador" name="identificador" value="{{ $empleado->identificador }}" readonly>
            </div>
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $empleado->nombre }}" readonly>
            </div>
            <div class="form-group">
                <label for="apellidos">Apellidos:</label>
                <input type="text" class="form-control" id="apellidos" name="apellidos" value="{{ $empleado->apellidos }}" readonly>
            </div>
            <div class="form-group">
                <label for="areatrabajo">Área de Trabajo:</label>
                <input type="text" class="form-control" id="areatrabajo" name="areatrabajo" value="{{ $empleado->areatrabajo }}" readonly>
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono:</label>
                <input type="text" class="form-control" id="telefono" name="telefono" value="{{ $empleado->telefono }}" readonly>
            </div>
            <div class="form-group">
                <label for="email">E-mail:</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ $empleado->email }}" readonly>
            </div>
            <div class="form-group">
                <label for="salida">Salida:</label>
                <input type="text" class="form-control" id="salida" name="salida" value="{{ now() }}" readonly>
            </div>
            <button type="submit" class="btn btn-danger">Registrar Salida</button>
        </form>
    </div>
</div>
@endsection
