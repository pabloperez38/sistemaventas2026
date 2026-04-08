@extends('layouts.admin')

@section('content')

<div class="card">
    <div class="card-header">
        <h4>Vista previa</h4>
        <p>Se afectarán {{ $total }} productos</p>
    </div>

    <div class="card-body">

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Precio actual</th>
                    <th>Precio nuevo</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($preview as $p)
                    <tr>
                        <td>{{ $p['nombre'] }}</td>
                        <td>${{ $p['precio_actual'] }}</td>
                        <td class="text-success">
                            ${{ $p['precio_nuevo'] }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>

</div>

@endsection