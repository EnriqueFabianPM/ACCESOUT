@extends('layouts.app')

@section('title', 'Página Principal del Guardia de Seguridad')

@section('content')
<div class="container-fluid d-flex justify-content-center align-items-center vh-100">
    <style>
        .btn-custom {
            background-color: #2bc021;
            color: #ffffff;
            border-color: #ffffff;
            width: 20vw; /* 20% of the viewport width */
            height: 20vh; /* 20% of the viewport height */
            font-size: 1.5rem; /* Larger text size */
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            margin: 10px; /* Space between buttons */
        }
        
        .btn-custom:hover {
            background-color: #1e8d13; /* Darker green on hover */
            border-color: #ffffff;
        }
    </style>
    <div class="text-center">
        <div class="btn-group d-flex flex-column align-items-center">
            <h1 class="text-center mb-4">Página Principal del Guardia de Seguridad</h1>
            <a href="{{ route('guardia.registrarentrada') }}" class="btn btn-custom">Registrar Entrada</a>
            <a href="{{ route('guardia.registrarsalida') }}" class="btn btn-custom">Registrar Salida</a>
        </div>
    </div>
</div>
@endsection
