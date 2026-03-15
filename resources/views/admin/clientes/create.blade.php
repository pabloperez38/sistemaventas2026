@extends('layouts.admin')

@section('content')
    <section id="basic-horizontal-layouts">
        <div class="row match-height">
            <div class="col-md-12 col-12">

                <form action="{{ route('admin.clientes.store') }}" method="post">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Agregar nuevo cliente</h4>
                        </div>

                        <div class="card-body">

                            <div class="row">

                                <div class="col-md-6">
                                    <label for="nombre">Nombre del cliente (*)</label>
                                    <div class="form-group has-icon-left mb-3">
                                        <div class="position-relative">
                                            <input type="text" value="{{ old('nombre') }}"
                                                class="form-control @error('nombre') is-invalid @enderror" id="nombre"
                                                placeholder="Ingrese nombre" name="nombre">
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
                                <div class="col-md-6">
                                    <label for="numero_documento">DNI/CUIT/CUIL del cliente (*)</label>
                                    <div class="form-group has-icon-left mb-3">
                                        <div class="position-relative">
                                            <input type="text" value="{{ old('numero_documento') }}"
                                                class="form-control @error('numero_documento') is-invalid @enderror"
                                                id="numero_documento" placeholder="Ingrese DNI/CUIT/CUIL"
                                                name="numero_documento">
                                            <div class="form-control-icon">
                                                <i class="bi bi-person-vcard"></i>
                                            </div>
                                            @error('numero_documento')
                                                <div class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-6">
                                    <label for="email">Email del cliente (*)</label>
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
                                <div class="col-md-6">
                                    <label for="telefono">Teléfono del cliente (*)</label>
                                    <div class="form-group has-icon-left mb-3">
                                        <div class="position-relative">
                                            <input type="telefono" value="{{ old('telefono') }}"
                                                class="form-control @error('telefono') is-invalid @enderror" id="telefono"
                                                placeholder="Ingrese telefono" name="telefono">
                                            <div class="form-control-icon">
                                                <i class="bi bi-phone"></i>
                                            </div>
                                            @error('telefono')
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

                                <a href="{{ route('admin.clientes.index') }}" class="btn btn-secondary mx-1"><i
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
