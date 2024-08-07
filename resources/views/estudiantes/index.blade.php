@extends('estudiantes.layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-center">
                    <h2>Sistema de Registro de Estudiantes UTSC</h2>
                    <a href="{{ route('home') }}" class="btn btn-primary btn-lg mt-3" style="background-color: #010201; padding: 10px;">
                        Volver al Inicio
                    </a>
                </div>
                <div class="card-body">
                    <a href="{{ route('estudiantes.create') }}" class="btn btn-success btn-sm mb-3" title="Registrar Nuevo Estudiante">
                        <i class="fa fa-plus" aria-hidden="true"></i> Registrar Nuevo Estudiante
                    </a>

                    <a href="{{ route('estudiantes.import') }}" class="btn btn-success btn-sm mb-3" title="Registrar Nuevo Estudiante">
                        <i class="fa fa-plus" aria-hidden="true"></i> Registro Multiple
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
                                    <th>Semestre</th>
                                    <th>Grupo</th>
                                    <th>Email</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($estudiantes as $estudiante)
                                <tr>
                                    <td>{{ $estudiante->identificador }}</td>
                                    <td>
                                        @if($estudiante->Fotoqr)
                                        <img src="{{ asset($estudiante->Fotoqr) }}" width="100px">
                                        @else
                                        No hay imagen
                                        @endif
                                    </td>
                                    <td>
                                        @if($estudiante->Foto)
                                        <img src="{{ asset($estudiante->Foto) }}" width="100px">
                                        @else
                                        No hay imagen
                                        @endif
                                    </td>
                                    <td>{{ $estudiante->nombre }}</td>
                                    <td>{{ $estudiante->apellidos }}</td>
                                    <td>{{ $estudiante->semestre }}</td>
                                    <td>{{ $estudiante->grupo }}</td>
                                    <td>{{ $estudiante->email }}</td>
                                    <td>
                                        <a href="{{ route('estudiantes.show', $estudiante->identificador) }}" class="btn btn-info btn-sm" title="Ver Estudiante">
                                            <i class="fa fa-eye" aria-hidden="true"></i> Ver
                                        </a>
                                        <a href="{{ route('estudiantes.edit', $estudiante->identificador) }}" class="btn btn-primary btn-sm" title="Editar Estudiante">
                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar
                                        </a>
                                        <form method="POST" action="{{ route('estudiantes.destroy', $estudiante->identificador) }}" accept-charset="UTF-8" style="display:inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Eliminar Estudiante" onclick="return confirm('¿Confirmar eliminar?')">
                                                <i class="fa fa-trash-o" aria-hidden="true"></i> Eliminar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center">No hay estudiantes registrados</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="pagination-wrapper"> {!! $estudiantes->links() !!} </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
