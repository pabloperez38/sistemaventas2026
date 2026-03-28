@extends('layouts.admin')

@section('content')
    <section class="section">
        <div class="row">
            <div class="col-12">

                <div class="card">
                    <div class="card-content">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title">
                                Backups
                            </h4>
                            <form action="{{ route('admin.backups.store') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn icon icon-left btn-success">
                                    <i class="bi bi-plus-circle"></i> Crear backup
                                </button>
                            </form>
                        </div>

                        <div class="card-body">

                            <div class="table-responsive shadow-sm rounded">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Archivo</th>
                                            <th>Tamaño</th>
                                            <th>Fecha</th>
                                            <th class="text-end">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($backups as $backup)
                                            <tr>

                                                <td>{{ $backup['name'] }}</td>
                                                <td>{{ number_format($backup['size'] / 1024 / 1024, 2) }} MB</td>
                                                <td>{{ \Carbon\Carbon::createFromTimestamp($backup['last_modified'])->format('d/m/Y H:i') }}
                                                </td>

                                                <td class="text-end">
                                                    <a href="{{ route('admin.backups.download', ['file' => $backup['name']]) }}"
                                                        class="btn icon icon-left btn-warning btn-sm">
                                                        <i class="bi bi-pencil"></i> Descargar
                                                    </a>
                                                    <form action="{{ route('admin.backups.destroy', $backup['name']) }}"
                                                        method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn icon icon-left btn-danger btn-sm">
                                                            <i class="bi bi-lock text-white"></i> Eliminar
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center text-muted py-4">
                                                    No hay backups disponibles
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>

                </div>

            </div>
        </div>
    </section>
@endsection
