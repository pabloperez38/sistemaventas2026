@extends('layouts.admin')

@section('content')
    <section id="basic-horizontal-layouts">
        <div class="row match-height">
            <div class="col-md-12 col-12">

                <form action="{{ route('admin.cajas.update', $caja->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Editar caja</h4>
                        </div>

                        <div class="card-body">

                            <div class="row">

                                <div class="col-md-4">
                                    <label for="fecha_apertura">Fecha de apertura (*)</label>
                                    <div class="form-group has-icon-left mb-3">
                                        <div class="position-relative">
                                            <input type="datetime-local" value="{{ old('fecha_apertura', $caja->fecha_apertura) }}"
                                                class="form-control @error('fecha_apertura') is-invalid @enderror"
                                                id="fecha_apertura" placeholder="Ingrese nombre" name="fecha_apertura">
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


                                <div class="col-md-4">
                                    <label for="monto_inicial">Monto inicial (*)</label>
                                    <div class="form-group has-icon-left mb-3">
                                        <div class="position-relative">
                                            <input type="text" value="{{ old('monto_inicial', $caja->monto_inicial) }}"
                                                class="form-control @error('monto_inicial') is-invalid @enderror"
                                                id="monto_inicial" placeholder="Ingrese monto inicial" name="monto_inicial">
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
                                <div class="col-md-4">
                                    <label for="descripcion">Descripción (*)</label>
                                    <div class="form-group has-icon-left mb-3">
                                        <div class="position-relative">
                                            <input type="text" value="{{ old('descripcion', $caja->descripcion) }}"
                                                class="form-control @error('descripcion') is-invalid @enderror"
                                                id="descripcion" placeholder="Ingrese descripción" name="descripcion">
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

                                <button type="submit" class="btn btn-warning"><i class="bi bi-floppy"></i>
                                    Actualizar</button>

                            </div>
                        </div>

                    </div>
                </form>
            </div>

        </div>

    </section>
@endsection
