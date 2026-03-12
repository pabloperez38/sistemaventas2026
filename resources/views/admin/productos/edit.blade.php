@extends('layouts.admin')

@section('content')
    <section id="basic-horizontal-layouts">
        <div class="row match-height">
            <div class="col-md-12 col-12">

                <form action="{{ route('admin.productos.update', $producto->id) }} " method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Editar producto</h4>
                        </div>

                        <div class="card-body">

                            <div class="row mb-3">

                                <div class="col-md-6">
                                    <label for="nombre">Nombre del producto (*)</label>
                                    <div class="form-group has-icon-left">
                                        <div class="position-relative">
                                            <input type="text" value="{{ old('nombre', $producto->nombre) }}"
                                                class="form-control @error('nombre') is-invalid @enderror" id="nombre"
                                                placeholder="Ingrese nombre del producto" name="nombre">
                                            <div class="form-control-icon">
                                                <i class="bi bi-box-seam"></i>
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
                                    <label for="codigo">Código del producto(*)</label>
                                    <div class="form-group has-icon-left">
                                        <div class="position-relative">
                                            <input type="text" value="{{ old('codigo', $producto->codigo) }}"
                                                class="form-control
                                                    @error('codigo')
                                                            is-invalid
                                                    @enderror"
                                                id="codigo" placeholder="Ingrese codigo del producto" name="codigo">
                                            <div class="form-control-icon">
                                                <i class="bi bi-upc-scan"></i>
                                            </div>
                                            @error('codigo')
                                                <div class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                    </div>
                                </div>

                            </div>

                            <div class="row mb-4">

                                <div class="col-md-6">
                                    <label for="categoria_id">Categoría del producto(*)</label>

                                    <select class="form-select @error('categoria_id') is-invalid @enderror"
                                        name="categoria_id" id="categoria_id">
                                     
                                        @foreach ($categorias as $categoria)
                                            <option value="{{ $categoria->id }}"
                                                {{ old('categoria_id', $producto->categoria_id) == $categoria->id ? 'selected' : '' }}>
                                                {{ $categoria->nombre }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('categoria_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>

                                <div class="col-md-6">
                                    <label for="marca_id">Marca del producto(*)</label>

                                    <select class="form-select @error('marca_id') is-invalid @enderror" name="marca_id"
                                        id="marca_id">
                                     
                                        @foreach ($marcas as $marca)
                                            <option value="{{ $marca->id }}"
                                                {{ old('marca_id', $producto->marca_id) == $marca->id ? 'selected' : '' }}>
                                                {{ $marca->nombre }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('marca_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-3">
                                    <label for="stock">Stock del producto(*)</label>
                                    <div class="form-group has-icon-left mb-3">

                                        <div class="position-relative">
                                            <input type="number" value="{{ old('stock', $producto->stock) }}"
                                                class="form-control
                                                    @error('stock')
                                                            is-invalid
                                                    @enderror"
                                                id="stock" placeholder="Ingrese stock del producto" name="stock">
                                            <div class="form-control-icon">
                                                <i class="bi bi-stack"></i>
                                            </div>
                                            @error('stock')
                                                <div class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label for="stock_minimo">Stock mínimo del producto(*)</label>
                                    <div class="form-group has-icon-left mb-3">

                                        <div class="position-relative">
                                            <input type="number" value="{{ old('stock_minimo', $producto->stock_minimo) }}"
                                                class="form-control
                                                    @error('stock_minimo')
                                                            is-invalid
                                                    @enderror"
                                                id="stock_minimo" placeholder="Ingrese stock mínimo del producto"
                                                name="stock_minimo">
                                            <div class="form-control-icon">
                                                <i class="bi bi-stack"></i>
                                            </div>
                                            @error('stock_minimo')
                                                <div class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label for="precio_compra">Precio de compra del producto(*)</label>
                                    <div class="form-group has-icon-left mb-3">

                                        <div class="position-relative">
                                            <input type="text"
                                                value="{{ old('precio_compra', $producto->precio_compra) }}"
                                                class="form-control
                                                    @error('precio_compra')
                                                            is-invalid
                                                    @enderror"
                                                id="precio_compra" placeholder="Ingrese precio de compra del producto"
                                                name="precio_compra">
                                            <div class="form-control-icon">
                                                <i class="bi bi-currency-dollar"></i>
                                            </div>
                                            @error('precio_compra')
                                                <div class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label for="precio_venta">Precio venta del producto(*)</label>
                                    <div class="form-group has-icon-left mb-3">

                                        <div class="position-relative">
                                            <input type="text"
                                              value="{{ old('precio_venta', $producto->precio_venta) }}"
                                                class="form-control
                                                    @error('precio_venta')
                                                            is-invalid
                                                    @enderror"
                                                id="precio_venta" placeholder="Ingrese precio de venta del producto"
                                                name="precio_venta">
                                            <div class="form-control-icon">
                                                <i class="bi bi-cash-stack"></i>

                                            </div>
                                            @error('precio_venta')
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

                                <a href="{{ route('admin.productos.index') }}" class="btn btn-secondary mx-1"><i
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
