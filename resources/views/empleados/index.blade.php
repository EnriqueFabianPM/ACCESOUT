@extends('empleados.layout')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2>Sistema de Registro de Empleados UTSC</h2>
                    <center><a href="{{ route('home') }}" style="background-color: #010201; padding: 10px;" class="btn btn-primary btn-lg mr-3">Volver al Inicio</a></center>
                </div>
                <div class="card-body">
                    <a href="{{ route('empleados.create') }}" class="btn btn-success btn-sm mb-3"
                        title="Registrar Nuevo Empleado">
                        <i class="fa fa-plus" aria-hidden="true"></i> Registrar Nuevo Empleado
                    </a>

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Identificador</th>
                                    <th>Código QR</th>
                                    <th>Foto</th>
                                    <th>Nombre</th>
                                    <th>Apellidos</th>
                                    <th>Area de Trabajo</th>
                                    <th>Telefono</th>
                                    <th>Email</th>
                                    <th>Entrada</th>
                                    <th>Salida</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($empleados as $empleado)
                                <tr>
                                    <td>{{ $empleado->identificador }}</td>
                                    <td>
                                        @if($empleado->Fotoqr)
                                        <img src="{{ asset($empleado->Fotoqr) }}" width="100px">
                                        @else
                                        No hay imagen
                                        @endif
                                    </td>
                                    <td>
                                        @if($empleado->Foto)
                                        <img src="{{ asset($empleado->Foto) }}" width="100px">
                                        @else
                                        No hay imagen
                                        @endif
                                    </td>
                                    <td>{{ $empleado->nombre }}</td>
                                    <td>{{ $empleado->apellidos }}</td>
                                    <td>{{ $empleado->areatrabajo }}</td>
                                    <td>{{ $empleado->telefono }}</td>
                                    <td>{{ $empleado->email }}</td>
                                    <td>{{ $empleado->entrada }}</td>
                                    <td>{{ $empleado->salida }}</td>
                                    <td>
                                        <a href="{{ route('empleados.show', $empleado->identificador) }}"
                                            class="btn btn-info btn-sm" title="Ver Empleado">
                                            <i class="fa fa-eye" aria-hidden="true"></i> Ver
                                        </a>
                                        <a href="{{ route('empleados.edit', $empleado->identificador) }}"
                                            class="btn btn-primary btn-sm" title="Editar Empleado">
                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar
                                        </a>

                                        <form method="POST"
                                            action="{{ route('empleados.destroy', $empleado->identificador) }}"
                                            accept-charset="UTF-8" style="display: inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                title="Eliminar Empleado"
                                                onclick="return confirm('¿Estás seguro de que quieres eliminar este empleado?')">
                                                <i class="fa fa-trash-o" aria-hidden="true"></i> Eliminar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="12" class="text-center">No hay empleados registrados.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{ $empleados->links() }} <!-- Agregar paginación si es necesario -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection