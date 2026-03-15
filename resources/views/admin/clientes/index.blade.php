@extends('layouts.admin')

@section('content')
    <section class="section">
        <div class="row">
            <div class="col-12">

                <div class="card">
                    <div class="card-content">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title">
                                Listado de clientes
                            </h4>

                            <a href="{{ route('admin.clientes.create') }}" class="btn icon icon-left btn-success">
                                <i class="bi bi-plus-circle"></i> Agregar cliente
                            </a>
                        </div>

                        <div class="card-body">

                            <div class="table-responsive shadow-sm rounded">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-dark">
                                        <tr>

                                            <th>Nombre</th>
                                            <th>DNI/CUIT/CUIL</th>
                                            <th>Email</th>
                                            <th>Teléfono</th>
                                            <th class="text-end">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($clientes as $cliente)
                                            <tr class="{{ $cliente->trashed() ? 'table-danger' : '' }}">

                                                <td>
                                                    {{ $cliente->nombre }}
                                                </td>
                                                <td>{{ $cliente->numero_documento }}</td>
                                                <td>{{ $cliente->email }}</td>
                                                <td>{{ $cliente->telefono }}</td>

                                                <td class="text-end">
                                                    @if ($cliente->trashed())
                                                        <a href="{{ route('admin.clientes.restaurar', $cliente->id) }}"
                                                            class="btn icon icon-left btn-success btn-sm"> <i
                                                                class="bi bi-arrow-counterclockwise"></i> Restaurar
                                                        </a>
                                                    @else
                                                        <a href="{{ route('admin.clientes.show', $cliente->id) }}"
                                                            class="btn icon icon-left btn-info btn-sm">
                                                            <i class="bi bi-eye"></i> Ver
                                                        </a>
                                                        <a href="{{ route('admin.clientes.edit', $cliente->id) }}"
                                                            class="btn icon icon-left btn-warning btn-sm">
                                                            <i class="bi bi-pencil"></i> Editar
                                                        </a>
                                                        <form action="{{ route('admin.clientes.destroy', $cliente->id) }}"
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
                                                <td colspan="5" class="text-center text-muted py-4">
                                                    No hay clientes registrados
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
