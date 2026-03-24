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

                            @if ($caja_abierta)
                                <a href="{{ route('admin.compras.create') }}" class="btn icon icon-left btn-success">
                                    <i class="bi bi-plus-circle"></i> Agregar compra
                                </a>
                            @else
                                <a href="{{ route('admin.cajas.create') }}" class="btn icon icon-left btn-danger">

                                    <i class="bi bi-plus-circle"></i> Abrir caja
                                </a>
                            @endif
                        </div>

                        <div class="card-body">

                            <div class="table-responsive shadow-sm rounded">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-dark">
                                        <tr>

                                            <th>Fecha</th>
                                            <th>Proveedor</th>
                                            <th>Comprobante</th>
                                            <th>Importe</th>
                                            <th>Estado</th>
                                            <th class="text-end">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($compras as $compra)
                                            <tr>
                                                <td>{{ \Carbon\Carbon::parse($compra->fecha)->format('d/m/Y') }}</td>
                                                <td>
                                                    {{ $compra->proveedor->empresa }}
                                                </td>
                                                <td>{{ $compra->comprobante }}</td>
                                                <td>${{ number_format($compra->precio_final, 2) }}</td>

                                                <td>
                                                    @if (!$compra->activo)
                                                        <span class="badge bg-danger">
                                                            <i class="bi bi-x-circle"></i> Anulada
                                                        </span>
                                                    @else
                                                        <span class="badge bg-success">
                                                            <i class="bi bi-check-circle"></i> Activa
                                                        </span>
                                                    @endif
                                                </td>

                                                <td class="text-end">
                                                    <a href="{{ route('admin.compras.show', $compra->id) }}"
                                                        class="btn btn-info btn-sm">
                                                        <i class="bi bi-eye"></i> Ver
                                                    </a>
                                                    @if ($compra->activo)
                                                        <form class="d-inline"
                                                            action="{{ route('admin.compras.anular', $compra->id) }}"
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
