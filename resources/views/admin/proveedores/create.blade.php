@extends('layouts.admin')

@section('content')
    <section id="basic-horizontal-layouts">
        <div class="row match-height">
            <div class="col-md-12 col-12">

                <form action="{{ route('admin.proveedores.store') }}" method="post">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Agregar nuevo proveedor</h4>
                        </div>

                        <div class="card-body">

                            <div class="row">

                                <div class="col-md-4">
                                    <label for="empresa">Nombre de la empresa (*)</label>
                                    <div class="form-group has-icon-left mb-3">
                                        <div class="position-relative">
                                            <input type="text" value="{{ old('empresa') }}"
                                                class="form-control @error('empresa') is-invalid @enderror" id="empresa"
                                                placeholder="Ingrese nombre de la empresa" name="empresa">
                                            <div class="form-control-icon">
                                                <i class="bi bi-building"></i>
                                            </div>
                                            @error('empresa')
                                                <div class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="cuit">CUIT de la empresa (*)</label>
                                    <div class="form-group has-icon-left mb-3">
                                        <div class="position-relative">
                                            <input type="text" value="{{ old('cuit') }}"
                                                class="form-control @error('cuit') is-invalid @enderror" id="cuit"
                                                placeholder="Ingrese cuit de la empresa" name="cuit">
                                            <div class="form-control-icon">
                                                <i class="bi bi-card-text"></i>
                                            </div>
                                            @error('cuit')
                                                <div class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="direccion">Dirección de la empresa (*)</label>
                                    <div class="form-group has-icon-left mb-3">
                                        <div class="position-relative">
                                            <input type="text" value="{{ old('direccion') }}"
                                                class="form-control @error('direccion') is-invalid @enderror" id="direccion"
                                                placeholder="Ingrese dirección de la empresa" name="direccion">
                                            <div class="form-control-icon">
                                                <i class="bi bi-geo-alt"></i>
                                            </div>
                                            @error('direccion')
                                                <div class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="telefono">Teléfono de la empresa (*)</label>
                                    <div class="form-group has-icon-left mb-3">
                                        <div class="position-relative">
                                            <input type="text" value="{{ old('telefono') }}"
                                                class="form-control @error('telefono') is-invalid @enderror" id="telefono"
                                                placeholder="Ingrese telpefono de la empresa" name="telefono">
                                            <div class="form-control-icon">
                                                <i class="bi bi-telephone"></i>
                                            </div>
                                            @error('telefono')
                                                <div class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="nombre">Nombre del contacto (*)</label>
                                    <div class="form-group has-icon-left mb-3">
                                        <div class="position-relative">
                                            <input type="text" value="{{ old('nombre') }}"
                                                class="form-control @error('nombre') is-invalid @enderror" id="nombre"
                                                placeholder="Ingrese nombre de contacto" name="nombre">
                                            <div class="form-control-icon">
                                                <i class="bi bi-person"></i>
                                            </div>
                                            @error('nombre')
                                                <div class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label for="email">Email del proveedor (*)</label>
                                    <div class="form-group has-icon-left mb-3">
                                        <div class="position-relative">
                                            <input type="email" value="{{ old('email') }}"
                                                class="form-control @error('email') is-invalid @enderror" id="email"
                                                placeholder="Ingrese email" name="email">
                                            <div class="form-control-icon">
                                                <i class="bi bi-envelope"></i>
                                            </div>
                                            @error('email')
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

                                <a href="{{ route('admin.proveedores.index') }}" class="btn btn-secondary mx-1"><i
                                        class="bi bi-arrow-left"></i>
                                    Cancelar</a>

                                <button type="submit" class="btn btn-primary"><i class="bi bi-floppy"></i>
                                    Guardar</button>

                            </div>
                        </div>

                    </div>
                </form>
            </div>

        </div>

    </section>
@endsection
