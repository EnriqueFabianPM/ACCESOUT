@extends('visitantes.layout')

@section('content')
<div class="row mt-4">
    <div class="col-lg-12 text-center">
        <h2>Mostrar Información de Visitante</h2>
    </div>
    <div class="col-lg-12">
        <div class="table-responsive">
            <table class="table table-bordered table-striped mx-auto" style="width: 80%;">
                <tr>
                    <th>Identificador:</th>
                    <td>{{ $visitante->identificador }}</td>
                </tr>
                <tr>
                    <th>Imagen de Código QR:</th>
                    <td><img src="{{ asset($visitante->Fotoqr) }}" width="100px"></td>
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
                    <th>Motivo:</th>
                    <td>{{ $visitante->motivo }}</td>
                </tr>
                <tr>
                    <th>Teléfono:</th>
                    <td>{{ $visitante->telefono }}</td>
                </tr>
                <tr>
                    <th>Email:</th>
                    <td>{{ $visitante->email }}</td>
                </tr>
            </table>
        </div>
    </div>
    <div class="col-lg-12 text-center mt-3">
        <form action="{{ route('visitantes.registrarEntrada', $visitante->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-primary btn-lg">Registrar Entrada</button>
        </form>
    </div>
</div>
@endsection
