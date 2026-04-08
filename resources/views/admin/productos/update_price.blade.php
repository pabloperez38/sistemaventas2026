@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Actualización masiva de precios</h4>
        </div>

        <form action="{{ route('admin.productos.actualizarPrecios') }}" method="POST">
            @csrf

            <div class="card-body">

                <div class="row">

                    {{-- CATEGORIAS --}}
                    <div class="col-md-6">
                        <label>Categorías</label>
                        <select name="categorias[]" class="form-select" multiple>
                            @foreach ($categorias as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->nombre }}</option>
                            @endforeach
                        </select>
                        <small>Si no seleccionás nada, aplica a todas</small>
                    </div>

                    {{-- MARCAS --}}
                    <div class="col-md-6">
                        <label>Marcas</label>
                        <select name="marcas[]" class="form-select" multiple>
                            @foreach ($marcas as $marca)
                                <option value="{{ $marca->id }}">{{ $marca->nombre }}</option>
                            @endforeach
                        </select>
                        <small>Si no seleccionás nada, aplica a todas</small>
                    </div>

                </div>

                <div class="row mt-4">

                    {{-- PORCENTAJE --}}
                    <div class="col-md-4">
                        <label>Porcentaje (%)</label>
                        <input type="number" step="0.01" name="porcentaje" class="form-control" required>
                    </div>

                    {{-- TIPO --}}
                    <div class="col-md-4">
                        <label>Tipo</label>
                        <select name="tipo" class="form-select">
                            <option value="aumento">Aumento</option>
                            <option value="descuento">Descuento</option>
                        </select>
                    </div>

                </div>

            </div>

            <div class="card-footer text-end">
                <button type="submit" name="accion" value="preview" class="btn btn-info">
                    Vista previa
                </button>

                <button type="submit" name="accion" value="aplicar" class="btn btn-primary">
                    Aplicar cambios
                </button>
            </div>
        </form>
    </div>
@endsection
