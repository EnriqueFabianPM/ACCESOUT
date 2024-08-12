@extends('visitantes.layout')

@section('content')
<div class="card">
    <div class="card-header">Registrar Nuevo Visitante</div>
    <center><a href="{{ route('InicioGuardia') }}" style="background-color: #010201; padding: 10px;" class="btn btn-primary btn-lg mr-3">Volver al Inicio</a></center>
    <div class="card-body">
        <form id="visitanteForm" action="{{ route('visitantes.store') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="identificador">Identificador: <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="identificador" name="identificador" required>
            </div>
            <div class="form-group">
                <label for="nombre">Nombre: <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="apellidos">Apellidos: <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="apellidos" name="apellidos" required>
            </div>
            <div class="form-group">
                <label for="motivo">Motivo de Visita: <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="motivo" name="motivo" required>
            </div>
            <div class="form-group">
                <label for="telefono">Telefono: <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="telefono" name="telefono" required>
            </div>
            <div class="form-group">
                <label for="email">E-mail: <span class="text-danger">*</span></label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            
            <button type="submit" class="btn btn-success">Registrar</button>
        </form>
    </div>
</div>
@endsection