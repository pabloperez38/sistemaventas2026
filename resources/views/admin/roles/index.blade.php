@extends('layouts.admin')

@section('content')
    <section class="section">
        <div class="row">
            <div class="col-12">

                <div class="card">
                    <div class="card-content">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title">
                                Listado de roles
                            </h4>

                            <a href="{{ route('admin.roles.create') }}" class="btn icon icon-left btn-success">
                                <i class="bi bi-plus-circle"></i> Agregar rol
                            </a>
                        </div>

                        <div class="card-body">

                            <div class="table-responsive shadow-sm rounded">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-dark text-center">
                                        <tr>

                                            <th>Nombre</th>

                                            <th class="text-center">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($roles as $role)
                                            <tr>

                                                <td class="fw-semibold">
                                                    {{ $role->name }}
                                                </td>

                                                <td class="text-center">
                                                    <a href="{{ route('admin.roles.edit', $role->id) }}"
                                                        class="btn icon btn-warning rounded-circle btn-sm">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <form action="{{ route('admin.roles.destroy', $role->id) }}"
                                                        method="post" class="d-inline delete-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="btn icon btn-danger btn-sm rounded-circle"
                                                            title="Eliminar">
                                                            <i class="bi bi-trash-fill text-white"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center text-muted py-4">
                                                    No hay roles registrados
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
