@extends('layouts.admin')

@section('content')
    <section class="section">
        <div class="row">
            <div class="col-12">

                <div class="card">
                    <div class="card-content">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title">
                                Listado de marcas
                            </h4>

                            <a href="{{ route('admin.marcas.create') }}" class="btn icon icon-left btn-success">
                                <i class="bi bi-plus-circle"></i> Agregar marca
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
                                        @forelse ($marcas as $marca)
                                              <tr class="{{ $marca->trashed() ? 'table-danger' : '' }}">

                                                <td>
                                                    {{ $marca->nombre }}
                                                </td>
                                                <td>
                                                    @if ($marca->activo == 1)
                                                        <span class="badge bg-success">Activa</span>
                                                    @else
                                                        <span class="badge bg-danger">Inactiva</span>
                                                    @endif

                                                </td>

                                                <td class="text-end">
                                                    @if ($marca->trashed())
                                                        <a href="{{ route('admin.marcas.restore', $marca->id) }}"
                                                            class="btn btn-success btn-sm">
                                                            <i class="bi bi-arrow-counterclockwise"></i> Restaurar
                                                        </a>
                                                    @else
                                                        <a href="{{ route('admin.marcas.edit', $marca->id) }}"
                                                            class="btn icon icon-left btn-warning btn-sm">
                                                            <i class="bi bi-pencil"></i> Editar
                                                        </a>
                                                        <form action="{{ route('admin.marcas.destroy', $marca->id) }}"
                                                            method="post" class="d-inline delete-form">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="btn icon icon-left btn-danger btn-sm"
                                                                title="Eliminar">
                                                                <i class="bi bi-trash-fill text-white"></i> Eliminar
                                                            </button>
                                                        </form>
                                                    @endif

                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center text-muted py-4">
                                                    No hay marcas registradas
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
