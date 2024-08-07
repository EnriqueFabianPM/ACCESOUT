@extends('layouts.app')

@section('title', 'Registro de Entrada')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="text-center">Página Principal de Registros</h1>
            <div class="text-center mt-4">
                <div class="btn-group" role="group" aria-label="Acciones del Guardia">
                    <a href="{{ route('estudiantes.showEntradaForm') }}" class="btn btn-primary btn-lg">Registrar Entrada de Estudiantes</a>
                    <a href="{{ route('empleados.showEntradaForm') }}" class="btn btn-primary btn-lg">Registrar Entrada de Empleados</a>
                    <a href="{{ route('visitantes.showEntradaForm') }}" class="btn btn-primary btn-lg">Registrar Entrada de Visitantes</a>
                    <a href="{{ route('scanner') }}" class="btn btn-warning btn-lg">Escanear QR</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
