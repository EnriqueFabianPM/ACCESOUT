@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Registrar Entrada para {{ $estudiante->nombre }} {{ $estudiante->apellidos }}</h1>

    <form action="{{ route('estudiantes.storeEntrada', $estudiante->id) }}" method="POST">
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
            <label for="entrada">Entrada</label>
            <input type="text" id="entrada" class="form-control" value="{{ $estudiante->entrada ? $estudiante->entrada->format('Y-m-d H:i:s') : 'No registrado' }}" readonly>
        </div>
        <button type="submit" class="btn btn-primary">Registrar Entrada</button>
    </form>
</div>
@endsection
