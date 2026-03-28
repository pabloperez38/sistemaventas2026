@extends('layouts.admin')

@section('content')
    <section id="basic-horizontal-layouts">
        <div class="row match-height">
            <div class="col-md-12 col-12">
                <div class="row">
                    <div class="col-md-4">
                        <form action="{{ route('admin.cajas.store_cierre', $caja->id) }}" method="post">
                            @csrf
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Cierre de caja {{ $caja->id }}</h4>
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
                                            <label for="monto_inicial">Monto de apertura (*)</label>
                                            <div class="form-group has-icon-left">
                                                <div class="position-relative">
                                                    <input type="text" value="{{ $caja->monto_inicial }}" disabled
                                                        class="form-control @error('monto_inicial') is-invalid @enderror"
                                                        id="monto_inicial" placeholder="Ingrese monto inicial"
                                                        name="monto_inicial">
                                                    <div class="form-control-icon">
                                                        <i class="bi bi-cash-stack"></i>
                                                    </div>
                                                    @error('monto_inicial')
                                                        <div class="invalid-feedback" role="alert">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>

                                            </div>

                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label for="fecha_cierre">Fecha de cierre (*)</label>
                                            <div class="form-group has-icon-left">
                                                <div class="position-relative">
                                                    <input type="datetime-local" value="{{ now()->format('Y-m-d\TH:i') }}"
                                                        class="form-control @error('fecha_cierre') is-invalid @enderror"
                                                        id="fecha_cierre" name="fecha_cierre">

                                                    <div class="form-control-icon">
                                                        <i class="bi bi-calendar-date"></i>
                                                    </div>

                                                    @error('fecha_cierre')
                                                        <div class="invalid-feedback" role="alert">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label for="monto_final">Monto final (*)</label>
                                            <div class="form-group has-icon-left">
                                                <div class="position-relative">
                                                    <input type="text" value="{{ old('monto_final') }}"
                                                        class="form-control @error('monto_final') is-invalid @enderror"
                                                        id="monto_final" placeholder="Ingrese monto final"
                                                        name="monto_final">
                                                    <div class="form-control-icon">
                                                        <i class="bi bi-cash-stack"></i>
                                                    </div>
                                                    @error('monto_final')
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
                    </div>
                    <div class="col-md-8">
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
