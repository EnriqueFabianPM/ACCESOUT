@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Registrar Salida para {{ $estudiante->nombre }} {{ $estudiante->apellidos }}</h1>

    <form action="{{ route('estudiantes.storeSalida', $estudiante->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="identificador">Identificador</label>
            <input type="text" id="identificador" class="form-control" value="{{ $estudiante->identificador }}" readonly>
        </div>
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" class="form-control" value="{{ $estudiante->nombre }}" readonly>
        </div>
        <div class="form-group">
            <label for="apellidos">Apellidos</label>
            <input type="text" id="apellidos" class="form-control" value="{{ $estudiante->apellidos }}" readonly>
        </div>
        <div class="form-group">
            <label for="salida">Salida</label>
            <input type="text" id="salida" class="form-control" value="{{ $estudiante->salida ? $estudiante->salida->format('Y-m-d H:i:s') : 'No registrado' }}" readonly>
        </div>
        <button type="submit" class="btn btn-primary">Registrar Salida</button>
    </form>
</div>
@endsection
