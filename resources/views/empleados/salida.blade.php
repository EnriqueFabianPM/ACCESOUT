@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Registrar Salida para {{ $empleado->nombre }} {{ $empleado->apellidos }}</h1>

    <form action="{{ route('empleados.storeSalida', $empleado->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="identificador">Identificador</label>
            <input type="text" id="identificador" class="form-control" value="{{ $empleado->identificador }}" readonly>
        </div>
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" class="form-control" value="{{ $empleado->nombre }}" readonly>
        </div>
        <div class="form-group">
            <label for="apellidos">Apellidos</label>
            <input type="text" id="apellidos" class="form-control" value="{{ $empleado->apellidos }}" readonly>
        </div>
        <div class="form-group">
            <label for="salida">Salida</label>
            <input type="text" id="salida" class="form-control" value="{{ $empleado->salida ? $empleado->salida->format('Y-m-d H:i:s') : 'No registrado' }}" readonly>
        </div>
        <button type="submit" class="btn btn-primary">Registrar Salida</button>
    </form>
</div>
@endsection
