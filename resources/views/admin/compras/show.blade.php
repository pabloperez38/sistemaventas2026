@extends('layouts.admin')

@section('content')
    <section class="section">

        <div class="page-heading">

            <div class="d-flex justify-content-between align-items-center mb-3">

                <h3>
                    <i class="bi bi-receipt"></i>
                    Detalle de Compra #{{ $compra->id }}

                    @if ($compra->activo)
                        <span class="badge bg-success ms-2">
                            <i class="bi bi-check-circle"></i> Activa
                        </span>
                    @else
                        <span class="badge bg-danger ms-2">
                            <i class="bi bi-x-circle"></i> Anulada
                        </span>
                    @endif
                </h3>

                <a href="{{ route('admin.compras.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Volver
                </a>

            </div>

        </div>

        @if (!$compra->activo)
            <div class="alert alert-danger mt-3">

                <i class="bi bi-exclamation-triangle-fill"></i>

                Esta compra fue <strong>ANULADA</strong>.
                El stock de los productos ya fue revertido.

            </div>
        @endif

        <div class="row">

            {{-- PROVEEDOR --}}
            <div class="col-md-3">

                <div class="card shadow-sm">

                    <div class="card-body text-center">

                        <i class="bi bi-truck fs-1 text-primary"></i>

                        <h6 class="mt-2 text-muted">Proveedor</h6>

                        <h5>{{ $compra->proveedor->empresa }}</h5>
                        <h6>Contacto: {{ $compra->proveedor->nombre }}</h6>

                    </div>

                </div>

            </div>


            {{-- FECHA --}}
            <div class="col-md-3">

                <div class="card shadow-sm">

                    <div class="card-body text-center">

                        <i class="bi bi-calendar fs-1 text-success"></i>

                        <h6 class="mt-2 text-muted">Fecha</h6>

                        <h5>
                            {{ \Carbon\Carbon::parse($compra->fecha)->format('d/m/Y') }}
                        </h5>

                    </div>

                </div>

            </div>


            {{-- COMPROBANTE --}}
            <div class="col-md-3">

                <div class="card shadow-sm">

                    <div class="card-body text-center">

                        <i class="bi bi-file-earmark-text fs-1 text-warning"></i>

                        <h6 class="mt-2 text-muted">Comprobante</h6>

                        <h5>{{ $compra->comprobante }}</h5>

                    </div>

                </div>

            </div>

            {{-- TOTAL --}}
            <div class="col-md-3">

                <div class="card shadow-sm bg-primary text-white">

                    <div class="card-body text-center">

                        <i class="bi bi-cash-stack fs-1"></i>

                        <h6 class="mt-2 text-white">Total Compra</h6>

                        <h4 class="text-white">
                            $ {{ number_format($compra->precio_final, 2, ',', '.') }}
                        </h4>

                    </div>

                </div>

            </div>

        </div>



        {{-- TABLA DE PRODUCTOS --}}

        <div class="card mt-4 shadow-sm">

            <div class="card-header">

                <h5 class="card-title">

                    <i class="bi bi-box-seam"></i>
                    Productos de la compra

                </h5>

            </div>


            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-hover table-lg">

                        <thead class="table-light">

                            <tr>
                                <th>#</th>
                                <th>Código</th>
                                <th>Producto</th>
                                <th class="text-center">Cantidad</th>
                                <th class="text-end">Precio Compra</th>
                                <th class="text-end">Subtotal</th>
                            </tr>

                        </thead>

                        <tbody>

                            @foreach ($compra->detalles as $detalle)
                                <tr>

                                    <td>{{ $loop->iteration }}</td>

                                    <td>
                                        <span class="badge bg-light-secondary">
                                            {{ $detalle->producto->codigo }}
                                        </span>
                                    </td>

                                    <td>
                                        {{ $detalle->producto->nombre }}
                                    </td>

                                    <td class="text-center">

                                        <span class="badge bg-info">
                                            {{ $detalle->cantidad }}
                                        </span>

                                    </td>

                                    <td class="text-end">

                                        $ {{ number_format($detalle->precio_compra, 2, ',', '.') }}

                                    </td>

                                    <td class="text-end fw-bold">

                                        $
                                        {{ number_format($detalle->precio_compra * $detalle->cantidad, 2, ',', '.') }}

                                    </td>

                                </tr>
                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

        </div>



        {{-- TOTAL FINAL ESTILO FACTURA --}}

        <div class="row mt-4">

            <div class="col-md-4 ms-auto">

                <div class="card shadow-sm">

                    <div class="card-body">

                        <h5 class="mb-3">
                            <i class="bi bi-calculator"></i>
                            Resumen
                        </h5>

                        <div class="d-flex justify-content-between">

                            <span>Total de productos</span>

                            <strong>{{ $compra->detalles->sum('cantidad') }}</strong>

                        </div>

                        <hr>

                        <div class="d-flex justify-content-between fs-5">

                            <strong>Total Compra</strong>

                            <strong class="text-primary">

                                $
                                {{ number_format($compra->precio_final, 2, ',', '.') }}

                            </strong>

                        </div>

                    </div>

                </div>

            </div>

        </div>


    </section>
@endsection
