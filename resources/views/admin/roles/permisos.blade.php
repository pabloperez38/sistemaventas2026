@extends('layouts.admin')

@section('content')
    <section id="basic-horizontal-layouts">
        <div class="row match-height">
            <div class="col-md-12 col-12">

                <form action="{{ route('admin.roles.update_permisos', $rol->id) }} " method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Actualizar permisos rol {{ $rol->name }}</h4>
                        </div>

                        <div class="card-body">

                            <div class="row mb-3">

                                @foreach ($permisos as $modulo => $grupoPermisos)
                                    <div class="col-md-3">
                                        <label for="nombre"><strong>{{ $modulo }}</strong></label>
                                        <div class="form-group">

                                            @foreach ($grupoPermisos as $permiso)
                                                <div>
                                                    <label for="permiso_{{ $permiso->id }}"></label>
                                                    <input type="checkbox" name="permisos[]" value="{{ $permiso->id }}"
                                                        class="form-check-input" @checked($rol->hasPermissionTo($permiso->name))
                                                        id="permiso_{{ $permiso->id }}"><span>{{ $permiso->name }}</span>


                                                </div>
                                            @endforeach

                                        </div>
                                    </div>
                                @endforeach


                            </div>

                        </div>

                        <div class="card-footer">

                            <div class="d-flex justify-content-end">

                                <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary mx-1"><i
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
