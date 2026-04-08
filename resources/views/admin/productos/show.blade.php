@extends('layouts.admin')

@section('content')
    <section class="section">

        {{-- HEADER --}}
        <div class="page-heading mb-4 d-flex justify-content-between align-items-center">
            <div>
                <h3>
                    <i class="bi bi-box-seam text-primary"></i>
                    {{ $producto->nombre }}
                </h3>
                <p class="text-muted mb-0">Detalle completo del producto</p>
            </div>

            {{-- ESTADO STOCK --}}
            @if ($producto->stock <= $producto->stock_minimo)
                <span class="badge bg-danger fs-6">
                    🔴 Stock bajo
                </span>
            @else
                <span class="badge bg-success fs-6">
                    🟢 En stock
                </span>
            @endif
        </div>

        <div class="row">

            {{-- IMAGEN --}}
            <div class="col-md-4">
                <div class="card shadow-sm border-0 text-center">
                    <div class="card-body">

                        @if ($producto->imagen)
                            <img src="{{ asset('storage/' . $producto->imagen) }}" class="img-fluid rounded"
                                style="max-height: 200px;">
                        @else
                            <i class="bi bi-image text-muted" style="font-size: 80px;"></i>
                            <p class="text-muted mt-2">Sin imagen</p>
                        @endif

                    </div>
                </div>
            </div>

            {{-- INFO --}}
            <div class="col-md-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-light mb-4">
                        <strong><i class="bi bi-info-circle text-primary"></i> Información</strong>
                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Código:</strong> {{ $producto->codigo }}</p>
                                <p><strong>Categoría:</strong> {{ $producto->categoria->nombre }}</p>
                            </div>

                            <div class="col-md-6">
                                <p><strong>Marca:</strong> {{ $producto->marca->nombre }}</p>
                                <p><strong>Stock mínimo:</strong> {{ $producto->stock_minimo }}</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>

        {{-- STOCK + PRECIOS --}}
        <div class="row mt-3">

            {{-- STOCK --}}
            <div class="col-md-4">
                <div class="card shadow border-0 text-center">
                    <div class="card-body">
                        <i class="bi bi-stack text-warning fs-2"></i>
                        <h5 class="mt-2">Stock actual</h5>
                        <h2 class="{{ $producto->stock <= $producto->stock_minimo ? 'text-danger' : 'text-primary' }}">
                            {{ $producto->stock }}
                        </h2>
                    </div>
                </div>
            </div>

            {{-- PRECIO COMPRA --}}
            <div class="col-md-4">
                <div class="card shadow border-0 text-center">
                    <div class="card-body">
                        <i class="bi bi-currency-dollar text-success fs-2"></i>
                        <h5 class="mt-2">Compra</h5>
                        <h3 class="text-success">
                            ${{ number_format($producto->precio_compra, 2, ',', '.') }}
                        </h3>
                    </div>
                </div>
            </div>

            {{-- PRECIO VENTA --}}
            <div class="col-md-4">
                <div class="card shadow border-0 text-center">
                    <div class="card-body">
                        <i class="bi bi-cash-stack text-primary fs-2"></i>
                        <h5 class="mt-2">Venta</h5>
                        <h3 class="text-primary">
                            ${{ number_format($producto->precio_venta, 2, ',', '.') }}
                        </h3>
                    </div>
                </div>
            </div>

        </div>

        {{-- MARGEN --}}
        @php
            $margen =
                $producto->precio_compra > 0
                    ? (($producto->precio_venta - $producto->precio_compra) / $producto->precio_compra) * 100
                    : 0;
        @endphp

        <div class="row mt-3">
            <div class="col-md-12">
                <div class="card shadow border-0 text-center">
                    <div class="card-body">

                        <i class="bi bi-graph-up-arrow text-info fs-2"></i>
                        <h5 class="mt-2">Margen de ganancia</h5>

                        <h3 class="{{ $margen < 0 ? 'text-danger' : 'text-success' }}">
                            {{ number_format($margen, 2) }}%
                        </h3>

                    </div>
                </div>
            </div>
        </div>

        {{-- FOOTER --}}
        <div class="mt-4 d-flex justify-content-between">

            <a href="{{ route('admin.productos.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Volver
            </a>

            <a href="{{ route('admin.productos.edit', $producto->id) }}" class="btn btn-warning">
                <i class="bi bi-pencil"></i> Editar
            </a>

        </div>

    </section>
@endsection
