@extends('layouts.app')

@section('title', 'Página Principal de Recursos Humanos')

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
            top: 120px;
            left: 150px;
        }

        .top-right {
            top: 120px;
            right: 150px;
        }

        .top-middle {
            top: 120px;
            right: 480px;
        }
    </style>
    <h1 class="text-center mb-4">Página Principal de Recursos Humanos</h1>
    <a href="{{ route('RecHumanos.menuEmpleadosVisitantes') }}" class="btn btn-custom top-left">Ir a Menu de Empleados y Visitantes</a>
    <a href="{{ route('home') }}" class="btn btn-custom top-right">Volver a Acceso UT</a>
</div>
@endsection