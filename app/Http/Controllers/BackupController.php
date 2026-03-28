<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;

class BackupController extends Controller
{
    public function index()
    {
        $disk = Storage::disk('local');
        $backupPath = trim((string) config('backup.backup.name', ''), '/');

        try {
            $files = $disk->allFiles($backupPath);
        } catch (\Throwable $e) {

            return view('admin.backups.index', ['backups' => []])
                ->with('swal', [
                    'icon' => 'error',
                    'title' => 'No se pudo lisar la carpeta de respaldos',
                    'timer' => 2000
                ]);
        };

        $backups = collect($files)
            ->filter(fn(string $path) => str_ends_with(strtolower($path), '.zip'))
            ->map(function (string $path) use ($disk) {
                return [
                    'name' => basename($path),
                    'path' => $path,
                    'size' => $disk->size($path),
                    'last_modified' => $disk->lastModified($path)
                ];
            })
            ->sortByDesc('last_modified')
            ->values();

        return view('admin.backups.index', compact('backups'));
    }

    public function store(Request $request)
    {
        try {
            // Intentar con Artisan primero
            Artisan::call('backup:run');

            // Si hay output de error lo revisamos
            $output = Artisan::output();

            if (str_contains(strtolower($output), 'failed') || str_contains(strtolower($output), 'error')) {
                throw new \Exception($output);
            }

            return redirect()->route('admin.backups.index')
                ->with('swal', [
                    'icon' => 'success',
                    'title' => 'Backup realizado exitosamente (Artisan)',
                    'timer' => 2000
                ]);
        } catch (\Throwable $e) {

            // 🔥 Fallback: ejecutar como consola real
            try {
                $command = '"C:\xampp\php\php.exe" "' . base_path('artisan') . '" backup:run 2>&1';

                exec($command, $outputExec, $result);

                if ($result !== 0) {
                    throw new \Exception(implode("\n", $outputExec));
                }

                return redirect()->route('admin.backups.index')
                    ->with('swal', [
                        'icon' => 'success',
                        'title' => 'Backup realizado (modo fallback)',
                        'timer' => 2000
                    ]);
            } catch (\Throwable $e2) {

                return redirect()->route('admin.backups.index')
                    ->with('swal', [
                        'icon' => 'error',
                        'title' => 'Error al generar el backup',
                        'text' => $e2->getMessage(),
                    ]);
            }
        }
    }


    public function download($file)
    {
        $safeFile = basename($file);
        $path = $this->resolveBackupPath($safeFile);

        if (!$path) {
            return back()->with('swal', [
                'icon' => 'error',
                'title' => 'Archivo no encontrado',
                'timer' => 2000
            ]);
        }

        return response()->download(Storage::disk('local')->path($path), $safeFile);
    }

    private function resolveBackupPath(string $file): ?string
    {
        $disk = Storage::disk('local');
        $backupPath = trim((string) config('backup.backup.name', ''), '/');
        $path = $backupPath . '/' . $file;

        if (!$disk->exists($path)) {
            return null;
        }

        return $path;
    }

    public function destroy($file)
    {
        $disk = Storage::disk('local');
        $backupPath = trim(config('backup.backup.name'), '/');

        $fullPath = $backupPath . '/' . $file;

        // 🔒 Seguridad (evitar rutas maliciosas)
        if (str_contains($file, '..')) {
            abort(403, 'Acceso no permitido');
        }

        // 📁 Verificar existencia
        if (!$disk->exists($fullPath)) {
            return redirect()->route('admin.backups.index')
                ->with('swal', [
                    'icon' => 'error',
                    'title' => 'Archivo no encontrado',
                    'timer' => 2000
                ]);
        }

        // 🗑️ Eliminar archivo
        $disk->delete($fullPath);

        return redirect()->route('admin.backups.index')
            ->with('swal', [
                'icon' => 'success',
                'title' => 'Backup eliminado correctamente',
                'timer' => 2000
            ]);
    }
}
