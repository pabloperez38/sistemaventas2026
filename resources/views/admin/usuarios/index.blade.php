@extends('layouts.admin')

@section('content')
    <section class="section">
        <div class="row">
            <div class="col-12">

                <div class="card">
                    <div class="card-content">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title">
                                Listado de usuarios
                            </h4>

                            <a href="{{ route('admin.usuarios.create') }}" class="btn icon icon-left btn-success">
                                <i class="bi bi-plus-circle"></i> Agregar usuario
                            </a>
                        </div>

                        <div class="card-body">

                            <div class="table-responsive shadow-sm rounded">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-dark">
                                        <tr>

                                            <th>Nombre</th>
                                            <th>Email</th>
                                            <th>Rol</th>
                                            <th class="text-end">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($usuarios as $usuario)
                                            <tr>

                                                <td>
                                                    {{ $usuario->name }}
                                                </td>
                                                <td>{{ $usuario->email }}</td>
                                                <td>{{ $usuario->roles->pluck('name')->first() }}</td>

                                                <td class="text-end">
                                                    <a href="{{ route('admin.usuarios.edit', $usuario->id) }}"
                                                        class="btn icon icon-left btn-warning btn-sm">
                                                        <i class="bi bi-pencil"></i> Editar
                                                    </a>
                                                    <form action="{{ route('admin.usuarios.destroy', $usuario->id) }}"
                                                        method="post" class="d-inline delete-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="btn icon icon-left btn-danger btn-sm"
                                                            title="Eliminar">
                                                            <i class="bi bi-trash-fill text-white"></i> Eliminar
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center text-muted py-4">
                                                    No hay usuarios registrados
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>

                </div>

            </div>
        </div>
    </section>
@endsection
