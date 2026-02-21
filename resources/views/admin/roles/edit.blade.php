@extends('layouts.admin')

@section('content')
    <section id="basic-horizontal-layouts">
        <div class="row match-height">
            <div class="col-md-12 col-12">

                <form action="{{ route('admin.roles.update', $role->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Editar rol</h4>
                        </div>

                        <div class="card-body">

                            <div class="row">

                                <div class="col-md-4">
                                    <label for="name">Nombre del rol (*)</label>
                                    <div class="form-group has-icon-left mb-3">
                                        <div class="position-relative">
                                            <input type="text" value="{{ old('name', $role->name) }}"
                                                class="form-control @error('name') is-invalid @enderror" id="name"
                                                placeholder="Ingrese nombre" name="name">
                                            <div class="form-control-icon">
                                                <i class="bi bi-shield-check"></i>
                                            </div>
                                            @error('name')
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

                                <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary mx-1">
                                    <i class="bi bi-arrow-left"></i>
                                    Cancelar
                                </a>

                                <button type="submit" class="btn btn-warning"><i class="bi bi-floppy"></i>
                                    Actualizar
                                </button>

                            </div>
                        </div>

                    </div>
                </form>
            </div>

        </div>

    </section>
@endsection
