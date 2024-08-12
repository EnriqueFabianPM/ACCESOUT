@extends('layouts.app')

@section('title', 'Pagina principal de Guardia de Seguridad')

@section('content')
<div class="container mt-4">
    <style>
        .btn-primary{
            align-items: center;
            background-color: #2bc021;
            column-gap: 10px;
            display: flex;
            padding: 10px;
            margin-top: 150px;
            border-color: #ffffff;


        }
        .btn-secondary{
            background-color: #2bc021;
            column-gap: 10px;
            display: flex;
            padding: 10px;
            margin-top: 150px;
            border-color: #ffffff;
        }
        .btn-info{
            background-color: #2bc021;
            color: #ffffff;
            column-gap: 10px;
            display: flex;
            padding: 10px;
            margin-top: 150px;
            border-color: #ffffff;

        }
    </style>
    <div class="row">
        <div class="col-lg-12">
            <h1 class="text-center">Registrar salida</h1>
            <div class="text-center mt-4">
                <div class="btn-group" role="group" aria-label="Acciones del Guardia">
                    <a href="{{ route('salidascanner') }}" class="btn btn-primary btn-lg">Escanear por Codigo QR</a>
                    <a class="btn btn-primary btn-lg">Escanear por Matricula (identificador)</a> <!--href="{'{ route('scan.handle') }}"-->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
