@extends('layouts.admin')

@section('content')
    <section class="section">
        <div class="row">
            <div class="col-12">

                <div class="card">
                    <div class="card-content">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title">
                                Listado de categorías
                            </h4>

                            <a href="{{ route('admin.categorias.create') }}" class="btn icon icon-left btn-success">
                                <i class="bi bi-plus-circle"></i> Agregar categoría
                            </a>
                        </div>

                        <div class="card-body">

                            <div class="table-responsive shadow-sm rounded">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-dark">
                                        <tr>

                                            <th>Nombre</th>
                                            <th>Estado</th>
                                            <th class="text-end">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($categorias as $categoria)
                                            <tr>

                                                <td>
                                                    {{ $categoria->nombre }}
                                                </td>
                                                <td>
                                                    @if ($categoria->estado == 1)
                                                        <span class="badge bg-success">Activo</span>
                                                    @else
                                                        <span class="badge bg-danger">Inactiva</span>
                                                    @endif

                                                </td>

                                                <td class="text-end">
                                                    <a href="{{ route('admin.categorias.edit', $categoria->id) }}"
                                                        class="btn icon btn-warning rounded-circle btn-sm">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <form action="{{ route('admin.categorias.destroy', $categoria->id) }}"
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
                                                    No hay categorías registradas
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
