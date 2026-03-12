@extends('layouts.admin')

@section('content')
    <section id="basic-horizontal-layouts">
        <div class="row match-height">
            <div class="col-md-12 col-12">

                <form action="{{ route('admin.categorias.update', $categoria->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Editar categoría</h4>
                        </div>

                        <div class="card-body">

                            <div class="row">

                                <div class="col-md-4">
                                    <label for="nombre">Nombre (*)</label>
                                    <div class="form-group has-icon-left mb-3">
                                        <div class="position-relative">
                                            <input type="text" value="{{ old('nombre', $categoria->nombre) }}"
                                                class="form-control @error('nombre') is-invalid @enderror" id="nombre"
                                                placeholder="Ingrese nombre" name="nombre">
                                            <div class="form-control-icon">
                                                <i class="bi bi-tag"></i>
                                            </div>
                                            @error('nombre')
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

                                <a href="{{ route('admin.categorias.index') }}" class="btn btn-secondary mx-1"><i
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
