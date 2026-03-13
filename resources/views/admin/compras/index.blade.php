@extends('layouts.admin')

@section('content')
    <section class="section">
        <div class="row">
            <div class="col-12">

                <div class="card">
                    <div class="card-content">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title">
                                Listado de compras
                            </h4>

                            <a href="{{ route('admin.compras.create') }}" class="btn icon icon-left btn-success">
                                <i class="bi bi-plus-circle"></i> Agregar compra
                            </a>
                        </div>

                        <div class="card-body">

                            <div class="table-responsive shadow-sm rounded">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-dark">
                                        <tr>

                                            <th>Fecha</th>
                                            <th>Producto</th>
                                            <th>Proveedor</th>
                                            <th>Precio</th>
                                            <th>Cantidad</th>
                                            <th class="text-end">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($compras as $compra)
                                            <tr>
                                                <td>{{ $compra->empresa }}</td>
                                                <td>
                                                    {{ $compra->cuit }}
                                                </td>
                                                <td>{{ $compra->nombre }}</td>
                                                <td>{{ $compra->email }}</td>
                                                <td>{{ $compra->telefono }}</td>

                                                <td class="text-end">

                                                    <a href="{{ route('admin.compras.edit', $compra->id) }}"
                                                        class="btn icon icon-left btn-warning btn-sm">
                                                        <i class="bi bi-pencil"></i> Editar
                                                    </a>
                                                    <form action="{{ route('admin.compras.destroy', $compra->id) }}"
                                                        method="post" class="d-inline delete-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn icon icon-left btn-danger btn-sm"
                                                            title="Eliminar">
                                                            <i class="bi bi-trash-fill text-white"></i> Eliminar
                                                        </button>
                                                    </form>

                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center text-muted py-4">
                                                    No hay compras registradas
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
