@extends('layouts.app')

@section('title', 'Todos los Logs')

@section('content')
<div class="container mt-4">
    <h1 class="text-center">Todos los Logs</h1>

    <!-- Estudiantes Logs -->
    <h2>Logs de Estudiantes</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Identificador</th>
                <th>Nombre</th>
                <th>Entrada</th>
                <th>Salida</th>
                <th>Última Actualización</th>
            </tr>
        </thead>
        <tbody>
            @foreach($estudiantesLogs as $estudiante)
            <tr>
                <td>{{ $estudiante->identificador }}</td>
                <td>{{ $estudiante->nombre }}</td>
                <td>{{ $estudiante->entrada }}</td>
                <td>{{ $estudiante->salida }}</td>
                <td>{{ $estudiante->updated_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Empleados Logs -->
    <h2>Logs de Empleados</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Identificador</th>
                <th>Nombre</th>
                <th>Entrada</th>
                <th>Salida</th>
                <th>Última Actualización</th>
            </tr>
        </thead>
        <tbody>
            @foreach($empleadosLogs as $empleado)
            <tr>
                <td>{{ $empleado->identificador }}</td>
                <td>{{ $empleado->nombre }}</td>
                <td>{{ $empleado->entrada }}</td>
                <td>{{ $empleado->salida }}</td>
                <td>{{ $empleado->updated_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Visitantes Logs -->
    <h2>Logs de Visitantes</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Identificador</th>
                <th>Nombre</th>
                <th>Entrada</th>
                <th>Salida</th>
                <th>Última Actualización</th>
            </tr>
        </thead>
        <tbody>
            @foreach($visitantesLogs as $visitante)
            <tr>
                <td>{{ $visitante->identificador }}</td>
                <td>{{ $visitante->nombre }}</td>
                <td>{{ $visitante->entrada }}</td>
                <td>{{ $visitante->salida }}</td>
                <td>{{ $visitante->updated_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
