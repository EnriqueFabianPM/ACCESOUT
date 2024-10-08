@extends('layouts.app')

@section('title', 'Menu de Estudiantes')

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
        <h1 class="mb-4">Menu de Estudiantes</h1>
        <div class="btn-group d-flex flex-column align-items-center">
            <a href="{{ route('estudiantes.index') }}" class="btn btn-custom">Ir a Tabla de Estudiantes</a>
            <a href="{{ route('InicioDireccion') }}" class="btn btn-custom">Volver a Direccion Academica</a>
        </div>
    </div>
</div>
@endsection