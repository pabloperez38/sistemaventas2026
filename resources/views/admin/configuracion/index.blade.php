@extends('layouts.admin')

@section('content')
    <section class="section">
        <div class="row">
            <div class="col-md-12 col-12">
                <div class="card">
                    <form class="form form-horizontal" method="POST" action="{{ route('admin.configuracion.update') }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-content">

                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="card-title">
                                    Configuración del sistema
                                </h4>

                            </div>

                            <div class="card-body">

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="nombre_empresa">Nombre(*)</label>
                                                <div class="form-group has-icon-left mb-3">
                                                    <div class="position-relative">
                                                        <input type="text"
                                                            value="{{ old('nombre_empresa', $configuracion->nombre_empresa ?? '') }}"
                                                            class="form-control @error('nombre_empresa') is-invalid @enderror"
                                                            id="nombre_empresa" placeholder="Ingrese nombre empresa" name="nombre_empresa">
                                                        <div class="form-control-icon">
                                                            <i class="bi bi-building"></i>
                                                        </div>
                                                        @error('nombre_empresa')
                                                            <div class="invalid-feedback" role="alert">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="direccion">Dirección(*)</label>
                                                <div class="form-group has-icon-left mb-3">
                                                    <div class="position-relative">
                                                        <input type="text"
                                                            value="{{ old('direccion', $configuracion->direccion ?? '') }}"
                                                            class="form-control @error('direccion') is-invalid @enderror"
                                                            id="direccion" placeholder="Ingrese direccion" name="direccion">
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
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="telefono">Teléfono(*)</label>
                                                <div class="form-group has-icon-left mb-3">
                                                    <div class="position-relative">
                                                        <input type="text"
                                                            value="{{ old('telefono', $configuracion->telefono ?? '') }}"
                                                            class="form-control @error('telefono') is-invalid @enderror"
                                                            id="telefono" placeholder="Ingrese telefono" name="telefono">
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
                                            <div class="col-md-6">
                                                <label for="email">Email(*)</label>
                                                <div class="form-group has-icon-left mb-3">
                                                    <div class="position-relative">
                                                        <input type="text"
                                                            value="{{ old('email', $configuracion->email ?? '') }}"
                                                            class="form-control @error('email') is-invalid @enderror"
                                                            id="email" placeholder="Ingrese email" name="email">
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
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="descripcion">Descripcion(*)</label>
                                                <div class="form-group has-icon-left mb-3">
                                                    <div class="position-relative">
                                                        <input type="text"
                                                            value="{{ old('descripcion', $configuracion->descripcion ?? '') }}"
                                                            class="form-control @error('descripcion') is-invalid @enderror"
                                                            id="descripcion" placeholder="Ingrese descripcion"
                                                            name="descripcion">
                                                        <div class="form-control-icon">
                                                            <i class="bi bi-building"></i>
                                                        </div>
                                                        @error('descripcion')
                                                            <div class="invalid-feedback" role="alert">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="cuit">CUIT(*)</label>
                                                <div class="form-group has-icon-left mb-3">
                                                    <div class="position-relative">
                                                        <input type="text"
                                                            value="{{ old('cuit', $configuracion->cuit ?? '') }}"
                                                            class="form-control @error('cuit') is-invalid @enderror"
                                                            id="cuit" placeholder="Ingrese cuit" name="cuit">
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
                                            <div class="col-md-3">
                                                <label for="ciudad">Ciudad(*)</label>
                                                <div class="form-group has-icon-left mb-3">
                                                    <div class="position-relative">
                                                        <input type="text"
                                                            value="{{ old('ciudad', $configuracion->ciudad ?? '') }}"
                                                            class="form-control @error('ciudad') is-invalid @enderror"
                                                            id="ciudad" placeholder="Ingrese ciudad" name="ciudad">
                                                        <div class="form-control-icon">
                                                            <i class="bi bi-geo-alt"></i>
                                                        </div>
                                                        @error('ciudad')
                                                            <div class="invalid-feedback" role="alert">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-md-12">

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="logo">Logo @if (!empty($configuracion->logo))
                                                            (*)
                                                        @endif
                                                    </label>
                                                    <div class="form-group mb-3">

                                                        <div class="position-relative">
                                                            <input type="file" name="logo" id="logo"
                                                                onchange="mostrarImagen(event)"
                                                                class="form-control @error('logo') is-invalid @enderror"
                                                                accept="image/*">

                                                            @error('logo')
                                                                <div class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <center>
                                                        @if (!empty($configuracion->logo))
                                                            <img id="logo-preview" width="100" height="100"
                                                                style="border-radius:50%; object-fit:cover;"
                                                                src="{{ asset('storage/' . $configuracion->logo) }}">
                                                        @else
                                                            <div id="logo-preview"
                                                                style="
                                                                width:100px;
                                                                height:100px;
                                                                border-radius:50%;
                                                                background-color:#e0e0e0;
                                                                display:flex;
                                                                border:2px dotted #b5b0b0;
                                                                align-items:center;
                                                                justify-content:center;
                                                                font-size:3rem;
                                                                color:#ded8d8;
                                                            ">

                                                            </div>
                                                        @endif
                                                    </center>
                                                </div>

                                                <script>
                                                    function mostrarImagen(event) {
                                                        const imagen = event.target.files[0];
                                                        if (!imagen) return;

                                                        const reader = new FileReader();
                                                        reader.onload = (e) => {
                                                            const preview = document.getElementById('logo-preview');

                                                            // Si era un div placeholder con ícono, lo reemplazamos por img
                                                            if (preview.tagName === 'DIV') {
                                                                const img = document.createElement('img');
                                                                img.id = 'logo-preview';
                                                                img.src = e.target.result;
                                                                img.width = 100;
                                                                img.height = 100;
                                                                img.style.borderRadius = '50%';
                                                                img.style.objectFit = 'cover';
                                                                preview.replaceWith(img);
                                                            } else {
                                                                preview.src = e.target.result;
                                                                preview.style.display = 'block';
                                                            }
                                                        };
                                                        reader.readAsDataURL(imagen);
                                                    }
                                                </script>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="imagen_login">Imagen de login
                                                        @if (empty($configuracion->imagen_login))
                                                            (*)
                                                        @endif
                                                    </label>
                                                    <div class="input-group mb-3">

                                                        <input type="file" name="imagen_login" id="imagen_login"
                                                            onchange="mostrarImagenFondo(event)"
                                                            class="form-control @error('imagen_login') is-invalid @enderror"
                                                            accept="image/*">
                                                        @error('imagen_login')
                                                            <div class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </div>
                                                        @enderror
                                                    </div>

                                                    <center>
                                                        @if (!empty($configuracion->imagen_login))
                                                            <img id="login-preview" width="100" height="100"
                                                                style="border-radius:50%; object-fit:cover;"
                                                                src="{{ asset('storage/' . $configuracion->imagen_login) }}">
                                                        @else
                                                            <div id="login-preview"
                                                                style="
                                                                width:100px;
                                                                height:100px;
                                                                border-radius:50%;
                                                                background-color:#e0e0e0;
                                                                display:flex;
                                                                border:2px dotted #b5b0b0;
                                                                align-items:center;
                                                                justify-content:center;
                                                                font-size:3rem;
                                                                color:#ded8d8;
                                                            ">

                                                            </div>
                                                        @endif
                                                    </center>
                                                </div>

                                                <script>
                                                    function mostrarImagenFondo(event) {
                                                        const imagen = event.target.files[0];
                                                        if (!imagen) return;

                                                        const reader = new FileReader();
                                                        reader.onload = (e) => {
                                                            const preview = document.getElementById('login-preview');

                                                            // Si es div placeholder con ícono, lo reemplazamos por img
                                                            if (preview.tagName === 'DIV') {
                                                                const img = document.createElement('img');
                                                                img.id = 'login-preview';
                                                                img.src = e.target.result;
                                                                img.width = 100;
                                                                img.height = 100;
                                                                img.style.borderRadius = '50%';
                                                                img.style.objectFit = 'cover';
                                                                preview.replaceWith(img);
                                                            } else {
                                                                preview.src = e.target.result;
                                                                preview.style.display = 'block';
                                                            }
                                                        };
                                                        reader.readAsDataURL(imagen);
                                                    }
                                                </script>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                            <div class="card-footer">

                                <div class="d-flex justify-content-end">

                                    <button type="submit" class="btn btn-primary"><i class="bi bi-floppy"></i>
                                        Guardar</button>

                                </div>
                            </div>

                        </div>
                    </form>
                </div>


            </div>

        </div>

    </section>
@endsection
