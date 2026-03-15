@extends('layouts.admin')

@section('content')
    <section id="basic-horizontal-layouts">
        <div class="row match-height">
            <div class="col-md-12 col-12">

                <form action="{{ route('admin.ventas.store') }}" id='form_venta' method="post">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Agregar nueva venta</h4>
                        </div>

                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-2">
                                    <label for="fecha">Fecha de venta(*)</label>
                                    <div class="form-group has-icon-left mb-3">
                                        <div class="position-relative">
                                            <input type="date" class="form-control  @error('fecha') is-invalid @enderror"
                                                id="fecha" placeholder="Ingrese fecha" name="fecha"
                                                value="{{ old('fecha', now()->format('Y-m-d')) }}">
                                            <div class="form-control-icon">
                                                <i class="bi bi-calendar"></i>
                                            </div>
                                            @error('fecha')
                                                <div class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                    </div>
                                </div>

                                <div class="col-md-5">
                                    <label for="cliente_id">Cliente(*)</label>

                                    <select class="form-select @error('cliente_id') is-invalid @enderror" name="cliente_id"
                                        id="cliente_id">

                                        @foreach ($clientes as $cliente)
                                            <option value="{{ $cliente->id }}"
                                                {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>
                                                {{ $cliente->nombre }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('cliente_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-2">
                                    <label for="cantidad">Cantidad(*)</label>
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
                                            <input autocomplete="off" type="text" value="{{ old('codigo') }}"
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
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl"
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
                                                        <table class="table" id="table2">
                                                            <thead>
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
                                                                    <tr>

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
                                                                            ${{ number_format($producto->precio_venta, 2, ',', '.') }}
                                                                        </td>

                                                                        <td class="text-end">

                                                                            <button type="button"
                                                                                class="btn icon icon-left btn-primary btn-sm seleccionar-btn"
                                                                                data-id="{{ $producto->codigo }}">
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
                                        <th>Eliminar</th>
                                    </thead>
                                    <tbody id="tabla_ventas">

                                        @php
                                            $contador = 1;
                                            $total = 0;
                                        @endphp

                                        @foreach ($tmp_ventas as $tmp_venta)
                                            @php
                                                $subtotal = $tmp_venta->precio_venta * $tmp_venta->cantidad;
                                                $total += $subtotal;
                                            @endphp

                                            <tr id="fila_producto_{{ $tmp_venta->producto->id }}">
                                                <td>{{ $contador }}</td>
                                                <td>{{ $tmp_venta->producto->codigo }}</td>
                                                <td class="cantidad">{{ $tmp_venta->cantidad }}</td>
                                                <td>{{ $tmp_venta->producto->nombre }}</td>

                                                <td>
                                                    <div class="input-group">
                                                        <span class="input-group-text">$</span>
                                                        <input type="text" class="form-control precio"
                                                            value="{{ number_format($tmp_venta->precio_venta, 2, ',', '.') }}"
                                                            data-id="{{ $tmp_venta->producto_id }}">
                                                    </div>

                                                </td>
                                                <td class="subtotal" data-valor="{{ $subtotal }}">
                                                    ${{ number_format($subtotal, 2, ',', '.') }}</td>
                                                <td>

                                                    <button type="button" class="btn btn-danger btn-sm delete-btn"
                                                        data-id="{{ $tmp_venta->id }}">
                                                        <i class="bi bi-trash"></i>
                                                    </button>

                                                </td>
                                            </tr>

                                            @php
                                                $contador++;
                                            @endphp
                                        @endforeach

                                    </tbody>
                                    {{--   <tfoot>
                                        <tr>
                                            <td colspan="6" style="text-align:right;">
                                                <h4>TOTAL</h4>
                                            </td>
                                            <td >
                                                <h3>${{ number_format($total, 2) }}</h3>
                                            </td>
                                        </tr>
                                    </tfoot> --}}
                                </table>

                                <div class="d-flex justify-content-end mt-3">
                                    <div class="card p-3 shadow-sm" style="min-width: 300px;">
                                        <div class="d-flex justify-content-between align-items-center" id="total_venta">
                                            <h4>Total:</h4>
                                            <h3>${{ number_format($total, 2) }}</h3>
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

@section('js')
    <script>
        $(document).on('blur', '.precio', function() {

            let input = $(this);
            let precio = parseFloat(input.val());
            let id = input.data('id');

            let fila = input.closest('tr');

            let cantidad = parseFloat(fila.find('.cantidad').text());

            let subtotal = precio * cantidad;

            fila.find('.subtotal')
                .data('valor', subtotal)
                .text('$' + dinero(subtotal));

            $.ajax({
                url: "{{ url('/admin/ventas/actualizar-precio/') }}",
                method: "POST",
                data: {
                    id: id,
                    precio: precio,
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {

                    calcularTotal();

                }
            });

        });


        $(document).on('click', '.delete-btn', function() {

            let id = $(this).data('id');

            if (id) {

                let fila = $(this).closest('tr'); // selecciona la fila del botón clickeado

                $.ajax({
                    url: "{{ url('/admin/ventas/create/tmp/') }}/" + id,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        _method: 'DELETE',
                    },
                    success: function(response) {

                        if (response.success) {

                            Swal.fire({
                                position: 'top-end',
                                icon: "success",
                                title: "Producto eliminado",
                                showConfirmButton: false,
                                timer: 1200
                            });

                            // eliminar la fila del DOM directamente
                            fila.remove();

                            // recalcular total después de eliminar
                            calcularTotal();

                        } else {

                            Swal.fire({
                                position: 'top-end',
                                icon: "error",
                                title: "Producto no encontrado",
                                showConfirmButton: false,
                                timer: 1500
                            });

                        }

                        // reset de inputs
                        $('#codigo').val('').focus();
                        $('#cantidad').val(1);

                    },
                    error: function(xhr) {
                        Swal.fire({
                            position: 'top-end',
                            icon: "error",
                            title: "Error al eliminar",
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                });
            }

        });

        /*  $('.seleccionar-btn').click(function() {

             let id_producto = $(this).data('id');
             $('#codigo').val(id_producto);
             $('#large').modal('hide');
             $('#codigo').focus();
             $('#cantidad').val(1);

         }); */

        function calcularTotal() {

            let total = 0;

            $('#tabla_ventas .subtotal').each(function() {

                total += parseFloat($(this).data('valor')) || 0;

            });

            $('#total_venta h3').text('$' +
                total.toLocaleString('es-AR', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                })
            );

        }

        function dinero(numero) {
            return Number(numero).toLocaleString('es-AR', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }

        $('#codigo').focus();

        $('#form_venta').on('keypress', function(e) {

            if (e.keyCode === 13) {
                e.preventDefault();
            }

        });

        $('#codigo').on('keyup', function(e) {

            if (e.which === 13) {

                let codigo = $(this).val();
                let cantidad = $('#cantidad').val();

                if (codigo.length >= 8) {
                    agregarProducto(codigo, cantidad);
                }

            }

        });

        $(document).on('click', '.seleccionar-btn', function() {

            let codigo = $(this).data('id');
            let cantidad = $('#cantidad').val();

            agregarProducto(codigo, cantidad);

            $('#large').modal('hide');

        });

        function agregarProducto(codigo, cantidad) {

            $.ajax({
                url: '{{ route('admin.ventas.tmp_ventas') }}',
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
                            timer: 1200
                        });

                        let producto = response.producto;

                        let fila_existente = $('#fila_producto_' + producto.id);

                        if (fila_existente.length > 0) {

                            fila_existente.find('.cantidad').text(response.cantidad);

                            fila_existente.find('.subtotal')
                                .data('valor', response.subtotal)
                                .text('$' + dinero(response.subtotal));

                            calcularTotal();

                        } else {

                            let contador = $('#tabla_ventas tr').length + 1;

                            let fila = `
                    <tr id="fila_producto_${producto.id}">
                        <td>${contador}</td>
                        <td>${producto.codigo}</td>
                        <td class="cantidad">${response.cantidad}</td>
                        <td>${producto.nombre}</td>
                        <td>
                            <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="text" class="form-control precio"
                                value="${dinero(producto.precio_venta)}"
                                data-id="{{ $producto->id }}">
                        </div>
                            
                            </td>
                        <td class="subtotal" data-valor="${response.subtotal}">
                            $${dinero(response.subtotal)}
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm delete-btn"
                                data-id="${response.id_venta}">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                    `;

                            $('#tabla_ventas').append(fila);

                            calcularTotal();
                        }

                        $('#codigo').val('').focus();
                        $('#cantidad').val(1);

                    } else {

                        Swal.fire({
                            position: 'top-end',
                            icon: "error",
                            title: "Producto no encontrado",
                            showConfirmButton: false,
                            timer: 1500
                        });

                        $('#codigo').val('').focus();
                        $('#cantidad').val(1);
                    }

                }
            });

        }
    </script>
@endsection
