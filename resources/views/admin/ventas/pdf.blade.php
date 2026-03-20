<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Factura</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        .wrapper {
            border: 1px solid #000;
            padding: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px;
        }

        th {
            background: #eee;
        }

        .no-border td {
            border: none;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }
    </style>
</head>

<body>

    <!-- ORIGINAL -->
    <table>
        <tr>
            <td class="wrapper text-center"><b>ORIGINAL</b></td>
        </tr>
    </table>
    <br>
    <!-- CABECERA -->
    <table>
        <tr>
            <!-- EMPRESA -->
            <td class="wrapper" width="50%">
                <h3 class="text-center">{{ $configuracion->nombre_empresa }}</h3>
                Dirección: {{ $configuracion->direccion }} <br>
                Tel: {{ $configuracion->telefono }} <br>
                Email: {{ $configuracion->email }}
            </td>

            <!-- FACTURA -->
            <td class="wrapper text-center" width="50%">
                <h3>COMPROBANTE</h3>
                {{ 'VE-' . str_pad($venta->id, 6, '0', STR_PAD_LEFT) }} <br>
                Fecha: {{ $venta->created_at->format('d/m/Y') }}
            </td>
        </tr>
    </table>
    <br>
    <br>
    <!-- CLIENTE -->
    <table>
        <tr>
            <td class="wrapper">
                Cliente: {{ $venta->cliente->nombre ?? 'Consumidor Final' }} <br>
                DNI/CUIT: {{ $venta->cliente->numero_documento ?? '-' }} <br>
                Tel: {{ $venta->cliente->telefono ?? '-' }}
            </td>
        </tr>
    </table>

    <!-- DETALLE -->
    <br>
    <br>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Producto</th>
                <th>Cant.</th>
                <th>Precio</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($venta->detalles as $i => $detalle)
                <tr>
                    <td class="text-center">{{ $i + 1 }}</td>
                    <td>{{ $detalle->producto->nombre }}</td>
                    <td class="text-center">{{ $detalle->cantidad }}</td>
                    <td class="text-right">$ {{ number_format($detalle->precio_venta, 2) }}</td>
                    <td class="text-right">
                        $ {{ number_format($detalle->cantidad * $detalle->precio_venta, 2) }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <br>
    <!-- TOTALES -->
    <table class="no-border">
        <tr>
            <td width="70%"></td>
            <td width="30%">
                <table>
                    <tr>
                        <td><b>Total</b></td>
                        <td class="text-right">
                            <h3> $ {{ number_format($venta->precio_final, 2) }} </h3>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
    <table class="no-border">
        <tr>
            <td>
        <tr>
            <td>Son:</td>
            <td class="text-right">
                {{ $total_letras }}
            </td>
        </tr>
        </td>

        </tr>
    </table>

    <!-- FIRMA -->
    <br><br><br>
    <table class="no-border">
        <tr>
            <td class="text-center">
                ___________________________<br>
                Firma
            </td>
        </tr>
    </table>

    <!-- ANULADA -->
    @if (!$venta->activo)
        <br>
        <table>
            <tr>
                <td class="text-center" style="color:red; font-size:20px;">
                    <b>VENTA ANULADA</b>
                </td>
            </tr>
        </table>
    @endif

</body>

</html>
