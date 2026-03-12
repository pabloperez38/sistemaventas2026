@extends('layouts.admin')

@section('content')
    <section id="basic-horizontal-layouts">
        <div class="row match-height">
            <div class="col-md-12 col-12">

                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Datos de producto: {{ $producto->nombre }}</h4>
                    </div>

                    <div class="card-body">

                        <div class="row mb-3">

                            <div class="col-md-6">
                                <strong>Nombre del producto </strong>
                                <div class="form-group has-icon-left">
                                    <div class="position-relative">

                                        {{ $producto->nombre }}

                                    </div>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <strong for="codigo">Código del producto</strong>
                                <div class="form-group has-icon-left">
                                    <div class="position-relative">
                                        {{ $producto->codigo }}


                                    </div>

                                </div>
                            </div>

                        </div>

                        <div class="row mb-4">

                            <div class="col-md-6">
                                <strong for="categoria_id">Categoría del producto</strong>

                                <div class="form-group has-icon-left">
                                    <div class="position-relative">
                                        {{ $producto->categoria->nombre }}
                                    </div>

                                </div>

                            </div>

                            <div class="col-md-6">
                                <strong for="marca_id">Marca del producto</strong>


                                <div class="form-group has-icon-left">
                                    <div class="position-relative">
                                        {{ $producto->marca->nombre }}
                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-3">
                                <strong for="stock">Stock del producto</strong>
                                <div class="form-group has-icon-left mb-3">

                                    <div class="position-relative">
                                        <div class="form-group has-icon-left">
                                            <div class="position-relative">

                                                {{ $producto->stock }}

                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-3">
                                <strong for="stock_minimo">Stock mínimo del producto</strong>
                                <div class="form-group has-icon-left mb-3">

                                    <div class="position-relative">
                                        <div class="form-group has-icon-left">
                                            <div class="position-relative">

                                                {{ $producto->stock_minimo }}

                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-3">
                                <strong for="precio_compra">Precio de compra del producto</strong>
                                <div class="form-group has-icon-left mb-3">

                                    <div class="position-relative">
                                        <div class="form-group has-icon-left">
                                            <div class="position-relative">

                                                $ {{ $producto->precio_compra }}

                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-3">
                                <strong for="precio_venta">Precio venta del producto</strong>
                                <div class="form-group has-icon-left mb-3">

                                    <div class="position-relative">
                                        <div class="form-group has-icon-left">
                                            <div class="position-relative">

                                                $ {{ $producto->precio_venta }}

                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="card-footer">

                        <div class="d-flex justify-content-end">

                            <a href="{{ route('admin.productos.index') }}" class="btn btn-secondary mx-1"><i
                                    class="bi bi-arrow-left"></i>
                                Volver</a>

                        </div>
                    </div>

                </div>

            </div>

        </div>

    </section>
@endsection
