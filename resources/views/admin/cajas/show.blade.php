@extends('layouts.admin')

@section('content')
    <section class="section">

        <div class="page-heading">

            <div class="d-flex justify-content-between align-items-center mb-3">

                <h3>
                    <i class="bi bi-cash-stack"></i>
                    Detalles de caja #{{ $caja->id }}

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

        <div class="row">

            {{-- USUARIO --}}
            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <i class="bi bi-person fs-1 text-primary"></i>
                        <h6 class="mt-2 text-muted">Usuario</h6>
                        <h5>{{ Auth::user()->name }}</h5>
                    </div>
                </div>
            </div>

            {{-- APERTURA --}}
            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <i class="bi bi-calendar-plus fs-1 text-success"></i>
                        <h6 class="mt-2 text-muted">Apertura</h6>
                        <h5>{{ $caja->fecha_apertura->format('d/m/Y H:i') }}</h5>
                    </div>
                </div>
            </div>

            {{-- CIERRE --}}
            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <i class="bi bi-calendar-check fs-1 text-danger"></i>
                        <h6 class="mt-2 text-muted">Cierre</h6>
                        <h5>
                            {{ $caja->fecha_cierre ? $caja->fecha_cierre->format('d/m/Y H:i') : 'Sin cerrar' }}
                        </h5>
                    </div>
                </div>
            </div>

            {{-- MONTO INICIAL --}}
            <div class="col-md-3">
                <div class="card shadow-sm bg-primary text-white">
                    <div class="card-body text-center">
                        <i class="bi bi-wallet2 fs-1"></i>
                        <h6 class="mt-2 text-white">Monto inicial</h6>
                        <h4 class="text-white">$ {{ number_format($caja->monto_inicial, 2, ',', '.') }}</h4>
                    </div>
                </div>
            </div>

        </div>

        {{-- RESUMEN ECONÓMICO --}}
        <div class="row mt-4">

            <div class="col-md-2">
                <div class="card shadow-sm border-success">
                    <div class="card-body text-center">
                        <i class="bi bi-arrow-down-circle fs-1 text-success"></i>
                        <h6 class="mt-2 text-muted">Ingresos</h6>
                        <h5>$ {{ number_format($caja->ingresos, 2, ',', '.') }}</h5>
                    </div>
                </div>
            </div>

            <div class="col-md-2">
                <div class="card shadow-sm border-danger">
                    <div class="card-body text-center">
                        <i class="bi bi-arrow-up-circle fs-1 text-danger"></i>
                        <h6 class="mt-2 text-muted">Egresos</h6>
                        <h5>$ {{ number_format($caja->egresos, 2, ',', '.') }}</h5>
                    </div>
                </div>
            </div>

            <div class="col-md-2">
                <div class="card shadow-sm border-info">
                    <div class="card-body text-center">
                        <i class="bi bi-calculator fs-1 text-info"></i>
                        <h6 class="mt-2 text-muted">Esperado</h6>
                        <h5>$ {{ number_format($caja->total_esperado, 2, ',', '.') }}</h5>
                    </div>
                </div>
            </div>

            <div class="col-md-2">
                <div class="card shadow-sm border-dark">
                    <div class="card-body text-center">
                        <i class="bi bi-cash fs-1 text-dark"></i>
                        <h6 class="mt-2 text-muted">Real</h6>
                        <h5>$ {{ number_format($caja->total_real, 2, ',', '.') }}</h5>
                    </div>
                </div>
            </div>

            <div class="col-md-2">
                <div class="card shadow-sm {{ $caja->diferencia == 0 ? 'border-success' : 'border-danger' }}">
                    <div class="card-body text-center">
                        <i
                            class="bi bi-exclamation-circle fs-1 
                        {{ $caja->diferencia == 0 ? 'text-success' : 'text-danger' }}"></i>
                        <h6 class="mt-2 text-muted">Diferencia</h6>
                        <h5>
                            $ {{ number_format($caja->diferencia, 2, ',', '.') }}
                        </h5>
                    </div>
                </div>
            </div>

        </div>

        {{-- OBSERVACIÓN --}}
        <div class="card mt-4 shadow-sm">
            <div class="card-body">
                <h5>
                    <i class="bi bi-card-text"></i>
                    Observación
                </h5>

                <p class="mt-2">
                    {{ $caja->descripcion ?? 'Sin observaciones' }}
                </p>
            </div>
        </div>

    </section>
@endsection
