@extends('visitantes.layout')

@section('content')
<div class="row">
    <div class="col-lg-6">
        <h2>Registro de Entradas y Salidas</h2>
    </div>
</div>

<div class="row mt-4">
    <div class="col-lg-12">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuario ID</th>
                    <th>Tipo de Usuario</th>
                    <th>Acción</th>
                    <th>Fecha y Hora</th>
                </tr>
            </thead>
            <tbody>
                @foreach($visitantes as $log)
                <tr>
                    <td>{{ $log->id }}</td>
                    <td>{{ $log->user_id }}</td>
                    <td>{{ $log->user_type }}</td>
                    <td>{{ $log->action }}</td>
                    <td>{{ $log->timestamp }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
