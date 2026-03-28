@extends('layouts.admin')

@section('content')
    <section class="section">
        <div class="row">
            <div class="col-12">

                <div class="card">
                    <div class="card-content">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title">
                                Cajas
                            </h4>

                            @if (!$caja_abierta)
                                <a href="{{ route('admin.cajas.create') }}" class="btn icon icon-left btn-success">
                                    <i class="bi bi-plus-circle"></i> Abrir caja
                                </a>
                            @endif

                        </div>

                        <div class="card-body">

                            <div class="table-responsive shadow-sm rounded">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Fecha de apertura</th>
                                            <th>Monto inicial</th>
                                            <th>Fecha de cierre</th>
                                            <th>Monto final</th>
                                            <th class="text-end">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($cajas as $caja)
                                            <tr>

                                                <td>{{ $caja->fecha_apertura->format('d/m/Y H:i') }}</td>
                                                <td>$ {{ number_format($caja->monto_inicial, 2) }}</td>
                                                <td>{{ optional($caja->fecha_cierre)->format('d/m/Y - H:i') }}</td>
                                                <td>{{ is_null($caja->monto_final) ? '' : '$' . number_format($caja->monto_final, 2) }}
                                                </td>
                                                <td class="text-end">
                                                    <a href="{{ route('admin.cajas.ingreso-egreso', $caja->id) }}"
                                                        class="btn icon icon-left btn-primary btn-sm">
                                                        <i class="bi bi-arrow-down-up"></i> Ingresos - Egresos
                                                    </a>
                                                    <a href="{{ route('admin.cajas.show', $caja->id) }}"
                                                        class="btn icon icon-left btn-info btn-sm">
                                                        <i class="bi bi-eye"></i> Ver
                                                    </a>
                                                    @if (is_null($caja->fecha_cierre))
                                                        <a href="{{ route('admin.cajas.edit', $caja->id) }}"
                                                            class="btn icon icon-left btn-warning btn-sm">
                                                            <i class="bi bi-pencil"></i> Editar
                                                        </a>

                                                        <a href="{{ route('admin.cajas.cerrar', $caja->id) }}"
                                                            class="btn icon icon-left btn-danger btn-sm">
                                                            <i class="bi bi-lock text-white"></i> Cerrar
                                                        </a>
                                                    @endif

                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center text-muted py-4">
                                                    No hay cajas registrados
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
