@extends('visitantes.layout')

@section('content')
<div class="row">
    <div class="col-lg-6">
        <h2>Registrar Entrada de Visitante</h2>
    </div>
    <div class="col-lg-6 text-end">
        <a class="btn btn-primary" href="{{ route('visitantes.index') }}">Volver al Registro</a>
    </div>
</div>

<div class="row mt-4">
    <div class="col-lg-6">
        <table class="table table-bordered table-striped">
            <tr>
                <th>Identificador:</th>
                <td>{{ $visitante->identificador }}</td>
            </tr>
            <tr>
                <th>Foto del Visitante:</th>
                <td>
                    @if($visitante->Fotoqr)
                        <img src="{{ asset($visitante->Fotoqr) }}" width="100px">
                    @else
                        No disponible
                    @endif
                </td>
            </tr>
            <tr>
                <th>Nombre:</th>
                <td>{{ $visitante->nombre }}</td>
            </tr>
            <tr>
                <th>Apellidos:</th>
                <td>{{ $visitante->apellidos }}</td>
            </tr>
            <tr>
                <th>Motivo de Visita:</th>
                <td>{{ $visitante->motivo }}</td>
            </tr>
            <tr>
                <th>Telefono:</th>
                <td>{{ $visitante->telefono }}</td>
            </tr>
            <tr>
                <th>Email:</th>
                <td>{{ $visitante->email }}</td>
            </tr>
            <tr>
                <th>Entrada:</th>
                <td>{{ $visitante->entrada }}</td>
            </tr>
            <tr>
                <th>Salida:</th>
                <td>{{ $visitante->salida }}</td>
            </tr>
        </table>
    </div>
</div>

<form action="{{ route('visitantes.registrarEntrada', $visitante->id) }}" method="post">
    @csrf
    <div class="form-group">
        <label for="entrada">Registrar Entrada:</label>
        <input type="datetime-local" class="form-control" id="entrada" name="entrada" required>
    </div>
    <button type="submit" class="btn btn-success">Registrar Entrada</button>
</form>
@endsection
