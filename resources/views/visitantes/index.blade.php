@extends('visitantes.layout')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2>Sistema de Registro de Visitante UTSC</h2>
                    <center><a href="{{ route('home') }}" style="background-color: #010201; padding: 10px;" class="btn btn-primary btn-lg mr-3">Volver al Inicio</a></center>
                </div>
                <div class="card-body">
                    <a href="{{ route('visitantes.create') }}" class="btn btn-success btn-sm mb-3"
                        title="Registrar Nuevo Visitante">
                        <i class="fa fa-plus" aria-hidden="true"></i> Registrar Nuevo Visitante
                    </a>

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Identificador</th>
                                    <th>Código QR</th>
                                    <th>Nombre</th>
                                    <th>Apellidos</th>
                                    <th>Motivo de Visita</th>
                                    <th>Telefono</th>
                                    <th>Email</th>
                                    <th>Entrada</th>
                                    <th>Salida</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($visitantes as $visitante)
                                <tr>
                                    <td>{{ $visitante->identificador }}</td>
                                    <td>
                                        @if($visitante->Fotoqr)
                                        <img src="{{ asset($visitante->Fotoqr) }}" width="100px">
                                        @else
                                        No hay imagen
                                        @endif
                                    </td>
                                    <td>{{ $visitante->nombre }}</td>
                                    <td>{{ $visitante->apellidos }}</td>
                                    <td>{{ $visitante->motivo }}</td>
                                    <td>{{ $visitante->telefono }}</td>
                                    <td>{{ $visitante->email }}</td>
                                    <td>{{ $visitante->entrada }}</td>
                                    <td>{{ $visitante->salida }}</td>
                                    <td>
                                        <a href="{{ route('visitantes.show', $visitante->identificador) }}"
                                            class="btn btn-info btn-sm" title="Ver Visitante">
                                            <i class="fa fa-eye" aria-hidden="true"></i> Ver
                                        </a>
                                        <a href="{{ route('visitantes.edit', $visitante->identificador) }}"
                                            class="btn btn-primary btn-sm" title="Editar Visitante">
                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar
                                        </a>

                                        <form method="POST"
                                            action="{{ route('visitantes.destroy', $visitante->identificador) }}"
                                            accept-charset="UTF-8" style="display: inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                title="Eliminar Visitante"
                                                onclick="return confirm('¿Estás seguro de que quieres eliminar este visitante?')">
                                                <i class="fa fa-trash-o" aria-hidden="true"></i> Eliminar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="12" class="text-center">No hay visitantes registrados.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{ $visitantes->links() }} <!-- Agregar paginación si es necesario -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection