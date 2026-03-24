@extends('layouts.admin')

@section('content')
    <section class="section">

        <div class="page-heading">

            <div class="d-flex justify-content-between align-items-center mb-3">

                <h3>
                    <i class="bi bi-people"></i>
                    Cliente #{{ $cliente->id }}

                    @if ($cliente->deleted_at)
                        <span class="badge bg-danger ms-2">
                            <i class="bi bi-x-circle"></i> Eliminado
                        </span>
                    @else
                        <span class="badge bg-success ms-2">
                            <i class="bi bi-check-circle"></i> Activo
                        </span>
                    @endif
                </h3>

                <a href="{{ route('admin.clientes.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Volver
                </a>

            </div>

        </div>

        {{-- TARJETAS DE INFORMACIÓN --}}

        <div class="row">

            {{-- NOMBRE --}}
            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body text-center">

                        <i class="bi bi-person-circle fs-1 text-primary"></i>

                        <h6 class="mt-2 text-muted">Cliente</h6>

                        <h5>{{ $cliente->nombre }}</h5>

                    </div>
                </div>
            </div>

            {{-- DNI --}}
            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body text-center">

                        <i class="bi bi-person-vcard fs-1 text-info"></i>

                        <h6 class="mt-2 text-muted">DNI / CUIL</h6>

                        <h5>{{ $cliente->numero_documento }}</h5>

                    </div>
                </div>
            </div>

            {{-- TELÉFONO --}}
            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body text-center">

                        <i class="bi bi-telephone fs-1 text-success"></i>

                        <h6 class="mt-2 text-muted">Teléfono</h6>

                        <h5>{{ $cliente->telefono ?? 'No registrado' }}</h5>

                    </div>
                </div>
            </div>

            {{-- DIRECCIÓN --}}
            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body text-center">

                        <i class="bi bi-geo-alt fs-1 text-warning"></i>

                        <h6 class="mt-2 text-muted">Dirección</h6>

                        <h5>{{ $cliente->direccion ?? 'No registrada' }}</h5>

                    </div>
                </div>
            </div>

        </div>


        {{-- TARJETAS DE ESTADÍSTICAS --}}

        <div class="row mt-4">

            {{-- COMPRAS --}}
            <div class="col-md-6">

                <div class="card shadow-sm">

                    <div class="card-body text-center">

                        <i class="bi bi-cart-check fs-1 text-primary"></i>

                        <h6 class="mt-2 text-muted">Compras realizadas</h6>

                        <h3>{{ $cliente->ventas->count() }}</h3>

                    </div>

                </div>

            </div>


            {{-- TOTAL GASTADO --}}
            <div class="col-md-6 ">

                <div class="card shadow-sm bg-primary text-white">

                    <div class="card-body text-center">

                        <i class="bi bi-cash-stack fs-1"></i>

                        <h6 class="mt-2 text-white"">Total gastado</h6>

                        <h3 class="text-white">

                            $ {{ number_format($cliente->ventas->sum('precio_final'), 2, ',', '.') }}


                        </h3>

                    </div>

                </div>

            </div>

        </div>


        {{-- TABLA DE COMPRAS --}}

        <div class="card mt-4 shadow-sm">

            <div class="card-header">

                <h5 class="card-title">

                    <i class="bi bi-receipt"></i>
                    Historial de compras

                </h5>

            </div>

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-hover table-lg">

                        <thead class="table-light">

                            <tr>
                                <th>#</th>
                                <th>Fecha</th>
                                <th class="text-end">Total</th>
                                <th class="text-center">Acción</th>
                            </tr>

                        </thead>

                        <tbody>

                            @forelse ($cliente->ventas as $venta)
                                <tr>

                                    <td>{{ $venta->id }}</td>

                                    <td>
                                        {{ \Carbon\Carbon::parse($venta->fecha)->format('d/m/Y') }}
                                    </td>

                                    <td class="text-end">

                                        $ {{ number_format($venta->precio_final, 2, ',', '.') }}

                                    </td>

                                    <td class="text-center">

                                        <a href="{{ route('admin.ventas.show', $venta->id) }}"
                                            class="btn btn-sm btn-primary">

                                            <i class="bi bi-eye"></i>

                                        </a>

                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="5" class="text-center text-muted">
                                        Este cliente aún no tiene compras registradas
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </section>
@endsection
