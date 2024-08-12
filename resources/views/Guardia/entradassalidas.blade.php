@extends('layouts.app')  <!-- Assuming you have a general layout file -->

@section('content')
<div class="row mt-4">
    <div class="col-lg-12 text-center">
        <h2>Listado de Entradas y Salidas</h2>
    </div>

    <div class="col-lg-12">
        <div class="table-responsive">
            <table class="table table-bordered table-striped mx-auto" style="width: 80%;">
                <thead>
                    <tr>
                        <th>Identificador</th>
                        <th>Tipo de Usuario</th> <!-- Tipo de usuario, e.g., Estudiante, Empleado, Visitante -->
                        <th>Caseta</th>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>Entrada</th>
                        <th>Salida</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($entradassalidas as $registro)
                        <tr>
                            <td>{{ $registro->identificador }}</td>
                            <td>{{ $registro->tipo }}</td> <!-- Assuming you have a field indicating user type -->
                            <td>{{ $registro->caseta }}</td>
                            <td>{{ $registro->nombre }}</td>
                            <td>{{ $registro->apellidos }}</td>
                            <td>{{ $registro->entrada }}</td>
                            <td>{{ $registro->salida }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
