@extends('layouts.admin')

@section('content')
    <section class="section">
        <div class="row">
            <div class="col-12">

                <div class="card">
                    <div class="card-content">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title">
                                Listado de ventas
                            </h4>

                            <a href="{{ route('admin.ventas.create') }}" class="btn icon icon-left btn-success">
                                <i class="bi bi-plus-circle"></i> Agregar venta
                            </a>
                        </div>

                        <div class="card-body">

                            <div class="table-responsive shadow-sm rounded">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-dark">
                                        <tr>

                                            <th>Fecha</th>
                                            <th>Venta</th>
                                            <th>Cliente</th>
                                            <th>Importe</th>
                                            <th>Estado</th>
                                            <th class="text-end">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($ventas as $venta)
                                            <tr>
                                                <td>{{ \Carbon\Carbon::parse($venta->fecha)->format('d/m/Y') }}</td>
                                                <td>
                                                    {{ 'VE-' . str_pad($venta->id, 6, '0', STR_PAD_LEFT) }}
                                                </td>
                                                <td>
                                                    {{ $venta->cliente->nombre }}
                                                </td>
                                                <td>${{ number_format($venta->precio_final, 2) }}</td>

                                                <td>
                                                    @if (!$venta->activo)
                                                        <span class="badge bg-danger">
                                                            <i class="bi bi-x-circle"></i> Anulada
                                                        </span>
                                                    @else
                                                        <span class="badge bg-success">
                                                            <i class="bi bi-check-circle"></i> Finalizada
                                                        </span>
                                                    @endif
                                                </td>

                                                <td class="text-end">
                                                    <a href="{{ route('admin.ventas.pdf', $venta->id) }}"
                                                        class="btn btn-secondary btn-sm" target="_blank">
                                                        <i class="bi bi-printer"></i> Imprimir
                                                    </a>
                                                    <a href="{{ route('admin.ventas.show', $venta->id) }}"
                                                        class="btn btn-info btn-sm">
                                                        <i class="bi bi-eye"></i> Ver
                                                    </a>
                                                    @if ($venta->activo)
                                                        <form class="d-inline"
                                                            action="{{ route('admin.ventas.anular', $venta->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PUT')

                                                            <button class="btn btn-danger btn-sm">
                                                                <i class="bi bi-x-circle"></i> Anular
                                                            </button>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center text-muted py-4">
                                                    No hay ventas registradas
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
