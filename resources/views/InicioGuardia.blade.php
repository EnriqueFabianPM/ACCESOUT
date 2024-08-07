@extends('layouts.app')

@section('title', 'Inicio Guardia')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="text-center">Página Principal del Guardia de Seguridad</h1>
            <div class="text-center mt-4">
                <div class="btn-group" role="group" aria-label="Acciones del Guardia">
                    <a href="{{ route('estudiantes.showEntradaForm') }}" class="btn btn-primary btn-lg">Registrar Entrada</a>
                    <a href="{{ route('estudiantes.showSalidaForm') }}" class="btn btn-secondary btn-lg">Registrar Salida</a>
                    <a href="{{ route('estudiantes.log') }}" class="btn btn-info btn-lg">Ver Registros (Logs)</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
