@extends('layouts.app')

@section('title', 'Página Principal del Guardia de Seguridad')

@section('content')
<div class="container-fluid position-relative vh-100">
    <style>
        .btn-custom {
            background-color: #2bc021;
            color: #ffffff;
            border-color: #ffffff;
            width: 20vw; /* Adjusted width */
            height: 20vh; /* Adjusted height */
            font-size: 1.2rem; /* Adjusted font size */
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            position: absolute;
            z-index: 1000; /* Ensure buttons are above other content */
            margin: 10px; /* Space around buttons */
        }
        
        .btn-custom:hover {
            background-color: #1e8d13; /* Darker green on hover */
            border-color: #ffffff;
        }

        .top-left {
            top: 100px;
            left: 150px;
        }

        .top-right {
            top: 100px;
            right: 150px;
        }

        .bottom-left {
            bottom: 460px;
            left: 150px;
        }

        .bottom-right {
            bottom: 460px;
            right: 150px;
        }
    </style>
    <h1 class="text-center mb-4">Página Principal del Guardia de Seguridad</h1>
    <a href="{{ route('guardia.registrarentrada') }}" class="btn btn-custom top-left">Registrar Entrada</a>
    <a href="{{ route('guardia.registrarsalida') }}" class="btn btn-custom top-right">Registrar Salida</a>
    <a href="{{ route('guardia.registrarvisitante') }}" class="btn btn-custom bottom-left">Registrar Visitante</a>
    <a href="{{ route('home') }}" class="btn btn-custom bottom-right">Volver a Acceso UT</a>
</div>
@endsection
