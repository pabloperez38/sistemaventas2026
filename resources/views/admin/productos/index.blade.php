@extends('layouts.admin')

@section('content')
    <section class="section">
        <div class="row">
            <div class="col-12">

                <div class="card">
                    <div class="card-content">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title">
                                Listado de productos
                            </h4>

                            <a href="{{ route('admin.productos.create') }}" class="btn icon icon-left btn-success">
                                <i class="bi bi-plus-circle"></i> Agregar producto
                            </a>
                        </div>

                        <div class="card-body">

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <form action="{{ url('/admin/productos') }}" method="get">
                                        <div class="input-group">
                                            <input type="text" name="buscar" class="form-control"
                                                placeholder="Buscar..." value="{{ request()->get('buscar') ?? '' }}">
                                            <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i>
                                                Buscar
                                            </button>
                                            @if (request()->filled('buscar'))
                                                <a class="btn btn-danger" href="{{ route('admin.productos.index') }}">
                                                    <i class="bi bi-x-lg"></i> Limpiar
                                                </a>
                                            @endif
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="table-responsive shadow-sm rounded">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-dark">
                                        <tr>

                                            <th>Nombre</th>
                                            <th>Código</th>
                                            <th>Categoría</th>
                                            <th>Marca</th>
                                            <th>Precio de venta</th>
                                            <th>Stock</th>
                                            <th class="text-end">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($productos as $producto)
                                            <tr class="{{ $producto->trashed() ? 'table-danger' : '' }}">

                                                <td>
                                                    {{ $producto->nombre }}
                                                </td>
                                                <td>
                                                    {{ $producto->codigo }}
                                                </td>

                                                <td>
                                                    {{ $producto->categoria->nombre }}
                                                </td>
                                                <td>
                                                    {{ $producto->marca->nombre }}
                                                </td>
                                                <td>
                                                    <strong>${{ number_format($producto->precio_venta, 2, ',', '.') }}</strong>

                                                </td>
                                                <td>
                                                    {{ $producto->stock }}
                                                </td>


                                                <td class="text-end">
                                                    @if ($producto->trashed())
                                                        <a href="{{ route('admin.productos.restaurar', $producto->id) }}"
                                                            class="btn icon icon-left btn-success btn-sm"> <i
                                                                class="bi bi-arrow-counterclockwise"></i> Restaurar
                                                        </a>
                                                    @else
                                                        <a href="{{ route('admin.productos.show', $producto->id) }}"
                                                            class="btn icon icon-left btn-info btn-sm">
                                                            <i class="bi bi-eye"></i> Ver
                                                        </a>
                                                        <a href="{{ route('admin.productos.edit', $producto->id) }}"
                                                            class="btn icon icon-left btn-warning btn-sm">
                                                            <i class="bi bi-pencil"></i> Editar
                                                        </a>
                                                        <form
                                                            action="{{ route('admin.productos.destroy', $producto->id) }}"
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
                                                <td colspan="7" class="text-center text-muted py-4">
                                                    No hay productos registrados
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            @if ($productos->hasPages())
                                <div class="mt-3">
                                    {{ $productos->links('pagination::bootstrap-5') }}
                                </div>
                            @endif

                        </div>

                    </div>

                </div>

            </div>
        </div>
    </section>
@endsection
