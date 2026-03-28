@extends('layouts.admin')

@section('content')
    <section class="section">

        <div class="page-heading mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <h3>
                    <i class="bi bi-cash-stack"></i> Detalles de caja #{{ $caja->id }}
                    @if ($caja->fecha_cierre)
                        <span class="badge bg-success ms-2">
                            <i class="bi bi-check-circle"></i> Cerrada
                        </span>
                    @else
                        <span class="badge bg-warning ms-2">
                            <i class="bi bi-clock"></i> Abierta
                        </span>
                    @endif
                </h3>
                <a href="{{ route('admin.cajas.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Volver
                </a>
            </div>
        </div>

        {{-- ALERTA SI SIGUE ABIERTA --}}
        @if (!$caja->fecha_cierre)
            <div class="alert alert-warning mt-3">
                <i class="bi bi-exclamation-triangle-fill"></i>
                Esta caja aún está <strong>ABIERTA</strong>.
            </div>
        @endif

        {{-- FILA 1: USUARIO Y DATOS DE CAJA --}}
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card shadow-sm text-center p-3">
                    <i class="bi bi-person fs-1 text-primary"></i>
                    <h6 class="text-muted mt-2">Usuario</h6>
                    <h5>{{ Auth::user()->name }}</h5>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm text-center p-3">
                    <i class="bi bi-calendar-plus fs-1 text-success"></i>
                    <h6 class="text-muted mt-2">Apertura</h6>
                    <h5>{{ $caja->fecha_apertura->format('d/m/Y H:i') }}</h5>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm text-center p-3">
                    <i class="bi bi-calendar-check fs-1 text-danger"></i>
                    <h6 class="text-muted mt-2">Cierre</h6>
                    <h5>{{ $caja->fecha_cierre ? $caja->fecha_cierre->format('d/m/Y H:i') : 'Sin cerrar' }}</h5>
                </div>
            </div>
        </div>

        {{-- FILA 2: RESUMEN ECONÓMICO --}}
        <div class="row mb-4">
            <div class="col-md-2">
                <div class="card shadow-sm bg-primary text-white text-center p-3">
                    <i class="bi bi-wallet2 fs-1"></i>
                    <h6 class="mt-2 text-white">Monto inicial</h6>
                    <h5 class="text-white">$ {{ number_format($caja->monto_inicial, 2, ',', '.') }}</h5>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card shadow-sm border-success text-center p-3">
                    <i class="bi bi-arrow-down-circle fs-1 text-success"></i>
                    <h6 class="text-muted mt-2">Ingresos</h6>
                    <h5>$ {{ number_format($caja->ingresos, 2, ',', '.') }}</h5>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card shadow-sm border-danger text-center p-3">
                    <i class="bi bi-arrow-up-circle fs-1 text-danger"></i>
                    <h6 class="text-muted mt-2">Egresos</h6>
                    <h5>$ {{ number_format($caja->egresos, 2, ',', '.') }}</h5>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card shadow-sm border-info text-center p-3">
                    <i class="bi bi-calculator fs-1 text-info"></i>
                    <h6 class="text-muted mt-2">Total esperado</h6>
                    <h5>$ {{ number_format($caja->total_esperado, 2, ',', '.') }}</h5>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card shadow-sm border-dark text-center p-3">
                    <i class="bi bi-cash fs-1 text-dark"></i>
                    <h6 class="text-muted mt-2">Total real</h6>
                    <h5>$ {{ number_format($caja->total_real, 2, ',', '.') }}</h5>
                </div>
            </div>
            <div class="col-md-2">
                <div
                    class="card shadow-sm text-center p-3 {{ $caja->diferencia == 0 ? 'border-success' : 'border-danger' }}">
                    <i class="bi fs-1 {{ $caja->diferencia == 0 ? 'text-success' : 'text-danger' }}"></i>
                    <h6 class="text-muted mt-2">Diferencia</h6>
                    <h5>$ {{ number_format($caja->diferencia, 2, ',', '.') }}</h5>
                </div>
            </div>
        </div>

        {{-- FILA 3: VENTAS POR MÉTODO --}}
        <div class="row mb-4">
            @foreach ($totalesMetodos as $metodo => $monto)
                @php
                    $labels = [
                        'efectivo' => 'Ventas en efectivo',
                        'debito' => 'Ventas con débito',
                        'credito' => 'Ventas con crédito',
                        'transferencia' => 'Ventas por transferencia',
                    ];
                    $colors = [
                        'efectivo' => ['bg' => 'bg-success text-white', 'icon' => 'bi-cash'],
                        'debito' => ['bg' => 'bg-info text-white', 'icon' => 'bi-credit-card'],
                        'credito' => ['bg' => 'bg-primary text-white', 'icon' => 'bi-credit-card-2-back'],
                        'transferencia' => ['bg' => 'bg-warning text-dark', 'icon' => 'bi-bank'],
                    ];
                @endphp
                <div class="col-md-3 mb-3">
                    <div class="card shadow-sm {{ $colors[$metodo]['bg'] }} text-center p-3">
                        <i class="bi fs-1 {{ $colors[$metodo]['icon'] }}"></i>
                        <h6 class="mt-2 text-white">{{ $labels[$metodo] }}</h6>
                        <h5>$ {{ number_format($monto, 2, ',', '.') }}</h5>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- OBSERVACIÓN --}}
        <div class="card mt-4 shadow-sm">
            <div class="card-body">
                <h5><i class="bi bi-card-text"></i> Observación</h5>
                <p class="mt-2">{{ $caja->descripcion ?? 'Sin observaciones' }}</p>
            </div>
        </div>

    </section>
@endsection
