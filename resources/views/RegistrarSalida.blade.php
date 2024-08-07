@extends('layouts.app')

@section('title', 'Registro de Salida')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="text-center">Página Principal de Registros</h1>
            <div class="text-center mt-4">
                <div class="btn-group" role="group" aria-label="Acciones del Guardia">
                <a href="{{ route('estudiantes.showSalidaForm') }}" class="btn btn-secondary btn-lg">Registrar Salida de Estudiantes</a>
                    <a href="{{ route('empleados.showSalidaForm') }}" class="btn btn-secondary btn-lg">Registrar Salida de Empleados</a>
                    <a href="{{ route('visitantes.showSalidaForm') }}" class="btn btn-secondary btn-lg">Registrar Salida de Visitantes</a>
                    <a href="{{ route('scanner') }}" class="btn btn-warning btn-lg">Escanear QR</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
