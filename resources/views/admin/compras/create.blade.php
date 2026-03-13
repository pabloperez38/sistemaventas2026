@extends('layouts.admin')

@section('content')
    <section id="basic-horizontal-layouts">
        <div class="row match-height">
            <div class="col-md-12 col-12">

                <form action="{{ route('admin.compras.store') }}" id='form_compra' method="post">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Agregar nueva compra</h4>
                        </div>

                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-2">
                                    <label for="cantidad">Cantidad (*)</label>
                                    <div class="form-group has-icon-left mb-3">
                                        <div class="position-relative">
                                            <input type="number" value="{{ old('cantidad', 1) }}"
                                                class="form-control text-center @error('cantidad') is-invalid @enderror"
                                                id="cantidad" placeholder="Ingrese cantidad" name="cantidad">
                                            <div class="form-control-icon">
                                                <i class="bi bi-123"></i>
                                            </div>
                                            @error('cantidad')
                                                <div class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="codigo">Código de producto(*)</label>
                                    <div class="form-group has-icon-left mb-3">
                                        <div class="position-relative">
                                            <input type="text" value="{{ old('codigo') }}"
                                                class="form-control @error('codigo') is-invalid @enderror" id="codigo"
                                                placeholder="Ingrese codigo" name="codigo">
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

                                <div class="col-md-4 pt-4">

                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#large">
                                        <i class="bi bi-search"></i>
                                    </button>
                                    <div class="modal fade text-left" id="large" tabindex="-1" role="dialog"
                                        aria-labelledby="myModalLabel17" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg"
                                            role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="myModalLabel17">
                                                        Lista de productos
                                                    </h4>
                                                    <button type="button" class="close" data-bs-dismiss="modal"
                                                        aria-label="Close">
                                                        <i data-feather="x"></i>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="table-responsive shadow-sm rounded">
                                                        <table class="table table-hover align-middle mb-0">
                                                            <thead class="table-dark">
                                                                <tr>

                                                                    <th>Nombre</th>
                                                                    <th>Código</th>
                                                                    <th>Categoría</th>
                                                                    <th>Precio de venta</th>
                                                                    <th class="text-end">Acciones</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @forelse ($productos as $producto)
                                                                    <tr
                                                                        class="{{ $producto->trashed() ? 'table-danger' : '' }}">

                                                                        <td>
                                                                            {{ $producto->nombre }}
                                                                        </td>
                                                                        <td>
                                                                            {{ $producto->codigo }}
                                                                        </td>

                                                                        <td>
                                                                            {{ $producto->categoria->nombre }}
                                                                        </td>

                                                                        <td>
                                                                            {{ $producto->precio_venta }}
                                                                        </td>

                                                                        <td class="text-end">

                                                                            <button type="button"
                                                                                class="btn icon icon-left btn-primary btn-sm">
                                                                                <i class="bi bi-cart-plus"></i>
                                                                            </button>

                                                                        </td>
                                                                    </tr>
                                                                @empty
                                                                    <tr>
                                                                        <td colspan="7"
                                                                            class="text-center text-muted py-4">
                                                                            No hay productos registrados
                                                                        </td>
                                                                    </tr>
                                                                @endforelse
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    @if ($productos->hasPages())
                                                        <div class="mt-3">
                                                            {{ $productos->links('pagination::bootstrap-5') }}
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light-secondary"
                                                        data-bs-dismiss="modal">
                                                        <i class="bx bx-x d-block d-sm-none"></i>
                                                        <span class="d-none d-sm-block">Cerrar</span>
                                                    </button>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="{{ route('admin.productos.create') }}" class="btn btn-success">
                                        <i class="bi bi-plus-circle"></i>
                                    </a>

                                </div>
                            </div>

                            <div class="row">

                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <th>#</th>
                                        <th>Código</th>
                                        <th>Cantidad</th>
                                        <th>Nombre</th>
                                        <th>Costo</th>
                                        <th>Total</th>
                                    </thead>
                                    <tbody id="tabla_compras">
                                        @php
                                            $contador = 1;
                                        @endphp
                                        @foreach ($tmp_compras as $tmp_compra)
                                            <tr>
                                                <td>{{ $contador }}</td>
                                                <td>{{ $tmp_compra->producto->codigo }}</td>
                                                <td>{{ $tmp_compra->cantidad }}</td>
                                                <td>{{ $tmp_compra->producto->nombre }}</td>
                                                <td>{{ $tmp_compra->producto->precio_compra }}</td>
                                                <td>{{ $tmp_compra->producto->precio_compra * $tmp_compra->cantidad }}
                                                </td>
                                            </tr>
                                            @php
                                                $contador++;
                                            @endphp
                                        @endforeach

                                    </tbody>
                                </table>

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

@section('js')
    <script>
        $('#codigo').focus();

        $('#form_compra').on('keypress', function(e) {

            if (e.keyCode === 13) {
                e.preventDefault();
            }

        });
        $('#codigo').on('keyup', function(e) {

            if (e.which === 13) {

                let codigo = $(this).val();
                let cantidad = $('#cantidad').val();

                if (codigo.length >= 8) {

                    $.ajax({
                        url: '{{ route('admin.compras.tmp_compras') }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            codigo: codigo,
                            cantidad: cantidad
                        },
                        success: function(response) {

                            if (response.success) {

                                Swal.fire({
                                    position: 'top-end',
                                    icon: "success",
                                    title: "Producto agregado",
                                    showConfirmButton: false,
                                    timer: 1500
                                });

                                let producto = response.producto;
                                let contador = $('#tabla_compras tr').length + 1;
                                let fila = `
                                    <tr>
                                        <td>${contador}</td>
                                        <td>${producto.codigo}</td>
                                        <td>${response.cantidad}</td>
                                        <td>${producto.nombre}</td>
                                        <td>${producto.precio_compra}</td>
                                        <td>${response.subtotal}</td>
                                    </tr>
                                `;

                                $('#tabla_compras').append(fila);

                                $('#codigo').val('');
                                $('#codigo').focus();
                            }

                        }
                    });
                }
            }

        });
    </script>
@endsection
