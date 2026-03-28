<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\HttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {

        // 🔴 403
        $exceptions->render(function (HttpException $e, $request) {
            if ($e->getStatusCode() === 403) {
                return redirect()->route('admin.index')
                    ->with('swal', [
                        'icon' => 'error',
                        'title' => 'Acceso no permitido',
                        'text' => 'No tenés permisos',
                        'timer' => 2500
                    ]);
            }
        });

        // 🟠 404
        $exceptions->render(function (HttpException $e, $request) {
            if ($e->getStatusCode() === 404) {
                return redirect()->route('admin.index')
                    ->with('swal', [
                        'icon' => 'warning',
                        'title' => 'No encontrado',
                        'timer' => 2500
                    ]);
            }
        });
    })
    ->create();
