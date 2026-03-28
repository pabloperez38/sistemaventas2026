@extends('layouts.admin')

@section('content')
    <section id="basic-horizontal-layouts">
        <div class="row match-height">
            <div class="col-md-12 col-12">
                <div class="row">
                    <div class="col-md-4">

                        @if ($caja->activo == 1)
                            <form action="{{ route('admin.cajas.store_ingresos_egresos', $caja->id) }}" method="post">
                                @csrf
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Ingresos / Egresos - Caja {{ $caja->id }}</h4>
                                    </div>

                                    <div class="card-body">

                                        <div class="row">

                                            <div class="col-md-12 mb-3">
                                                <label for="fecha_apertura">Fecha de apertura (*)</label>
                                                <div class="form-group has-icon-left ">
                                                    <div class="position-relative">
                                                        <input type="datetime-local" value="{{ $caja->fecha_apertura }}"
                                                            disabled
                                                            class="form-control @error('fecha_apertura') is-invalid @enderror"
                                                            id="fecha_apertura" name="fecha_apertura">
                                                        <div class="form-control-icon">
                                                            <i class="bi bi-calendar-date"></i>
                                                        </div>
                                                        @error('fecha_apertura')
                                                            <div class="invalid-feedback" role="alert">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label for="tipo">Tipo de movimiento (*)</label>

                                                <select class="form-select @error('tipo') is-invalid @enderror"
                                                    name="tipo" id="tipo">

                                                    <option value="">Seleccione un tipo de movimiento</option>

                                                    <option value="ingreso"
                                                        {{ old('tipo') == 'ingreso' ? 'selected' : '' }}>
                                                        Ingreso
                                                    </option>

                                                    <option value="egreso" {{ old('tipo') == 'egreso' ? 'selected' : '' }}>
                                                        Egreso
                                                    </option>

                                                </select>

                                                @error('tipo')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror

                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label>Método de pago (*)</label>

                                                <select name="metodo_pago_id" class="form-select">
                                                    @foreach ($metodosPago as $metodo)
                                                        <option value="{{ $metodo->id }}">
                                                            {{ $metodo->nombre }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label for="monto">Monto (*)</label>
                                                <div class="form-group has-icon-left">
                                                    <div class="position-relative">
                                                        <input type="text" value="{{ old('monto') }}"
                                                            class="form-control @error('monto') is-invalid @enderror"
                                                            id="monto" placeholder="Ingrese monto inicial"
                                                            name="monto">
                                                        <div class="form-control-icon">
                                                            <i class="bi bi-cash-stack"></i>
                                                        </div>
                                                        @error('monto')
                                                            <div class="invalid-feedback" role="alert">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label for="descripcion">Descripción (*)</label>
                                                <div class="form-group has-icon-left">
                                                    <div class="position-relative">
                                                        <input type="text" value="{{ old('descripcion') }}"
                                                            class="form-control @error('descripcion') is-invalid @enderror"
                                                            id="descripcion" placeholder="Ingrese descripción"
                                                            name="descripcion">
                                                        <div class="form-control-icon">
                                                            <i class="bi bi-file-text"></i>
                                                        </div>
                                                        @error('descripcion')
                                                            <div class="invalid-feedback" role="alert">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="card-footer">

                                        <div class="d-flex justify-content-end">

                                            <a href="{{ route('admin.cajas.index') }}" class="btn btn-secondary mx-1"><i
                                                    class="bi bi-arrow-left"></i>
                                                Cancelar</a>

                                            <button type="submit" class="btn btn-primary"><i class="bi bi-floppy"></i>
                                                Guardar</button>

                                        </div>
                                    </div>

                                </div>
                            </form>
                        @else
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Ingresos / Egresos - Caja {{ $caja->id }}</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h4>
                                                        Fecha apertura:
                                                        {{ \Carbon\Carbon::parse($caja->fecha_apertura)->format('d/m/Y H:i') }}
                                                    </h4>
                                                    <h4>
                                                        Fecha cierre:
                                                        {{ \Carbon\Carbon::parse($caja->fecha_cierre)->format('d/m/Y H:i') }}
                                                    </h4>

                                                </div>
                                                <div class="card-body">
                                                    <h5> No se permiten movimientos en cajas cerradas</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-8">
                        <div class="card mb-4">

                            <div class="card-header">
                                <h4 class="card-title">Resumen de ingresos por método</h4>
                            </div>
                            <div class="card-body">

                                <div class="row g-3">
                                    <div class="col-md-3">
                                        <div class="p-3 bg-success text-white rounded shadow-sm text-center">
                                            <strong>Efectivo</strong>
                                            <h4 class="m-0 text-white">$
                                                {{ number_format($totalesMetodos['efectivo'], 2) }}
                                            </h4>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="p-3 bg-info text-white rounded shadow-sm text-center">
                                            <strong>Débito</strong>
                                            <h4 class="m-0 text-white">$
                                                {{ number_format($totalesMetodos['debito'], 2) }}
                                            </h4>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="p-3 bg-primary text-white rounded shadow-sm text-center">
                                            <strong>Crédito</strong>
                                            <h4 class="m-0 text-white">$
                                                {{ number_format($totalesMetodos['credito'], 2) }}
                                            </h4>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="p-3 bg-warning text-dark rounded shadow-sm text-center">
                                            <strong>Transferencia</strong>
                                            <h4 class="m-0">$
                                                {{ number_format($totalesMetodos['transferencia'], 2) }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Detalles</h4>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Fecha</th>
                                            <th>Tipo</th>
                                            <th>Descripción</th>
                                            <th class="text-end">Monto</th>
                                            <th>Método</th>
                                            <th class="text-end">Saldo</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($movimientos as $mov)
                                            <tr>
                                                <td>{{ \Carbon\Carbon::parse($mov['fecha'])->format('d/m/Y H:i') }}
                                                </td>

                                                {{-- Columna Tipo --}}
                                                <td>
                                                    @if ($mov['tipo'] == 'apertura')
                                                        <span class="badge bg-primary">Apertura</span>
                                                    @elseif ($mov['tipo'] == 'ingreso')
                                                        <span class="badge bg-success">Ingreso</span>
                                                    @elseif($mov['tipo'] == 'pago')
                                                        <span class="badge bg-info">Pago</span>
                                                    @else
                                                        <span class="badge bg-danger">Egreso</span>
                                                    @endif
                                                </td>

                                                <td>{{ $mov['descripcion'] }}</td>

                                                {{-- Columna Monto --}}
                                                <td class="text-end">
                                                    @if (in_array($mov['tipo'], ['apertura', 'ingreso']))
                                                        <span class="text-success">+ $
                                                            {{ number_format($mov['monto'], 2) }}</span>
                                                    @elseif ($mov['tipo'] == 'egreso')
                                                        <span class="text-danger">- $
                                                            {{ number_format($mov['monto'], 2) }}</span>
                                                    @elseif ($mov['tipo'] == 'pago')
                                                        <span class="text-primary">$
                                                            {{ number_format($mov['monto'], 2) }}</span>
                                                    @endif
                                                </td>

                                                {{-- Columna Método --}}
                                                <td>
                                                    @php
                                                        $tipo = ucfirst($mov['tipo']);
                                                        $metodo = $mov['metodo'] ?? 'Desconocido';
                                                    @endphp

                                                    @if ($mov['tipo'] == 'apertura')
                                                        <span class="badge bg-primary">Apertura</span>
                                                    @else
                                                        @php
                                                            // Color según tipo
                                                            $color = match ($mov['tipo']) {
                                                                'ingreso' => 'bg-success',
                                                                'egreso' => 'bg-danger',
                                                                'pago' => 'bg-info',
                                                                default => 'bg-secondary',
                                                            };

                                                            // Ajuste visual método
                                                            $metodoTexto = match (strtolower($metodo)) {
                                                                'efectivo' => 'Efectivo',
                                                                'debito' => 'Débito',
                                                                'credito' => 'Crédito',
                                                                'transferencia' => 'Transferencia',
                                                                'billetera' => 'Billetera',
                                                                default => 'Desconocido',
                                                            };
                                                        @endphp

                                                        <span class="badge {{ $color }}">
                                                            {{ $tipo }} - {{ $metodoTexto }}
                                                        </span>
                                                    @endif
                                                </td>

                                                {{-- Columna Saldo --}}
                                                <td class="text-end">
                                                    $ {{ number_format($mov['saldo'], 2) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>

                                    <tfoot>
                                        <tr>
                                            <td colspan="5" class="text-end">
                                                <h4>Total esperado en caja:</h4>
                                            </td>
                                            <td class="text-end">
                                                <h3>$ {{ number_format($saldoFinal, 2) }}</h3>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </section>
@endsection
