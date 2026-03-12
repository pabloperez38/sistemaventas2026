@extends('layouts.admin')

@section('content')
    <section id="basic-horizontal-layouts">
        <div class="row match-height">
            <div class="col-md-12 col-12">

                <form action="{{ route('admin.usuarios.store') }}" method="post">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Agregar nuevo usuario</h4>
                        </div>

                        <div class="card-body">

                            <div class="row">

                                <div class="col-md-4">
                                    <label for="name">Nombre del usuario (*)</label>
                                    <div class="form-group has-icon-left mb-3">
                                        <div class="position-relative">
                                            <input type="text" value="{{ old('name') }}"
                                                class="form-control @error('name') is-invalid @enderror" id="name"
                                                placeholder="Ingrese nombre" name="name">
                                            <div class="form-control-icon">
                                              <i class="bi bi-person"></i>
                                            </div>
                                            @error('name')
                                                <div class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="role">Rol del usuario(*)</label>

                                    <select class="form-select @error('role') is-invalid @enderror" name="role" id="role">
                                        <option value="">Seleccione un rol</option>

                                        @foreach ($roles as $role)
                                            <option value="{{ $role->name}}"
                                                {{ old('role') == $role->name ? 'selected' : '' }}>
                                                {{ $role->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('role')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>

                                <div class="col-md-4">
                                    <label for="email">Email del usuario (*)</label>
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

                            <div class="row">

                                <div class="col-md-6">
                                    <label for="password">Contraseña del usuario(*)</label>
                                    <div class="form-group has-icon-left mb-3">

                                        <div class="position-relative">
                                            <input type="password"
                                                class="form-control
                                                    @error('password')
                                                            is-invalid
                                                    @enderror"
                                                id="password" placeholder="Ingrese contraseña del usuario" name="password">
                                            <div class="form-control-icon">
                                                <i class="bi bi-lock-fill"></i>
                                            </div>
                                            @error('password')
                                                <div class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="password_confirmation">Repetir contraseña (*)</label>
                                    <div class="form-group has-icon-left mb-3">

                                        <div class="position-relative">
                                            <input type="password"
                                                class="form-control
                                                    @error('password_confirmation')
                                                            is-invalid
                                                    @enderror"
                                                id="password_confirmation" placeholder="Repita la contraseña del usuario"
                                                name="password_confirmation">
                                            <div class="form-control-icon">
                                                <i class="bi bi-lock-fill"></i>
                                            </div>
                                            @error('password_confirmation')
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

                                <a href="{{ route('admin.usuarios.index') }}" class="btn btn-secondary mx-1"><i
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
