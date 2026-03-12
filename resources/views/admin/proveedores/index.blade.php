@extends('layouts.admin')

@section('content')
    <section class="section">
        <div class="row">
            <div class="col-12">

                <div class="card">
                    <div class="card-content">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title">
                                Listado de proveedores
                            </h4>

                            <a href="{{ route('admin.proveedores.create') }}" class="btn icon icon-left btn-success">
                                <i class="bi bi-plus-circle"></i> Agregar proveedor
                            </a>
                        </div>

                        <div class="card-body">

                            <div class="table-responsive shadow-sm rounded">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-dark">
                                        <tr>

                                            <th>Empresa</th>
                                            <th>CUIT</th>
                                            <th>Nombre contacto</th>
                                            <th>Email</th>
                                            <th>Teléfono</th>
                                            <th class="text-end">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($proveedores as $proveedor)
                                            <tr class="{{ $proveedor->trashed() ? 'table-danger' : '' }}">
                                                <td>{{ $proveedor->empresa }}</td>
                                                <td>
                                                    {{ $proveedor->cuit }}
                                                </td>
                                                <td>{{ $proveedor->nombre }}</td>
                                                <td>{{ $proveedor->email }}</td>
                                                <td>{{ $proveedor->telefono }}</td>

                                                <td class="text-end">
                                                    @if ($proveedor->trashed())
                                                        <a href="{{ route('admin.proveedores.restaurar', $proveedor->id) }}"
                                                            class="btn icon icon-left btn-success btn-sm"> <i
                                                                class="bi bi-arrow-counterclockwise"></i> Restaurar
                                                        </a>
                                                    @else
                                                        <a href="{{ route('admin.proveedores.edit', $proveedor->id) }}"
                                                            class="btn icon icon-left btn-warning btn-sm">
                                                            <i class="bi bi-pencil"></i> Editar
                                                        </a>
                                                        <form
                                                            action="{{ route('admin.proveedores.destroy', $proveedor->id) }}"
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
                                                <td colspan="6" class="text-center text-muted py-4">
                                                    No hay proveedores registrados
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
