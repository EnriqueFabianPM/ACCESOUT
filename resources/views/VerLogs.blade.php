@extends('layouts.app')

@section('title', 'Registros (Logs)')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="text-center">Página Principal de Registros</h1>
            <div class="text-center mt-4">
                <div class="btn-group" role="group" aria-label="Acciones del Guardia">
                    <a href="{{ route('estudiantes.log') }}" class="btn btn-info btn-lg">Ver Logs de Estudiantes</a>
                    <a href="{{ route('empleados.log') }}" class="btn btn-info btn-lg">Ver Logs de Empleados</a>
                    <a href="{{ route('visitantes.log') }}" class="btn btn-info btn-lg">Ver Logs de Visitantes</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
