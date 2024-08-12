@extends('layouts.app')

@section('title', 'Registrar Entrada por Identificador')

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
        <h1 class="mb-4">Registrar Entrada por Identificador</h1>
        <!-- Display error message if available -->
        @if (session('error'))
            <p style="color: red;">{{ session('error') }}</p>
        @endif

        <!-- Form for scanning by identificador -->
        <form action="{{ route('guardia.entrar') }}" method="GET">
            @csrf
            <div class="form-group">
                <label for="identificador">Identificador:</label>
                <input type="text" id="identificador" name="identificador" class="form-control" required>
            </div>
            <button type="submit" style="background-color: #010201; padding: 10px;" class="btn btn-primary btn-lg mr-3">Buscar</button>
        </form>

        <!-- Buttons for other actions -->
        <div class="btn-group mt-4 d-flex flex-column align-items-center">
            <a href="{{ route('guardia.registrarentrada') }}" class="btn btn-custom">Volver a Registro de Entrada</a>
            <a href="{{ route('InicioGuardia') }}" class="btn btn-custom">Volver a Inicio</a>
        </div>
    </div>
</div>
@endsection