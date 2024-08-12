@extends('layouts.app')

@section('title', 'Página Principal de Direccion Academica')

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
    </style>
    <h1 class="text-center mb-4">Página Principal de Direccion Academica</h1>
    <a href="{{ route('DirAcademica.menuEstudiantes') }}" class="btn btn-custom top-left">Menu de Estudiantes</a>
    <a href="{{ route('home') }}" class="btn btn-custom top-right">Volver a Acceso UT</a>
</div>
@endsection