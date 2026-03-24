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
                                            <th class="text-end">Saldo</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($movimientos as $mov)
                                            <tr>
                                                <td>{{ \Carbon\Carbon::parse($mov['fecha'])->format('d/m/Y H:i') }}</td>

                                                <td>
                                                    @if ($mov['tipo'] == 'apertura')
                                                        <span class="badge bg-primary">Apertura</span>
                                                    @elseif($mov['tipo'] == 'ingreso')
                                                        <span class="badge bg-success">Ingreso</span>
                                                    @else
                                                        <span class="badge bg-danger">Egreso</span>
                                                    @endif
                                                </td>

                                                <td>{{ $mov['descripcion'] }}</td>

                                                <td class="text-end">
                                                    @if (in_array($mov['tipo'], ['apertura', 'ingreso']))
                                                        <span class="text-success">+ $
                                                            {{ number_format($mov['monto'], 2) }}</span>
                                                    @else
                                                        <span class="text-danger">- $
                                                            {{ number_format($mov['monto'], 2) }}</span>
                                                    @endif
                                                </td>
                                                <td class="text-end">
                                                    $ {{ number_format($mov['saldo'], 2) }}
                                                </td>
                                            </tr>
                                        @endforeach
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
