<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'pengelola' => \App\Http\Middleware\PengelolaMiddleware::class,
            'mahasiswa' => \App\Http\Middleware\MahasiswaMiddleware::class,
        ]);
        $middleware->redirectUsersTo(function () {
            $user = auth()->user();
            if (!$user) return '/login';

            if ($user->isAdmin()) {
                return '/admin/dashboard';
            } elseif ($user->isPengelola()) {
                return '/pengelola/dashboard';
            } elseif ($user->isMahasiswa()) {
                return '/mahasiswa/dashboard';
            }
            
            return '/';
        }); 
    })
    ->withExceptions(function (Exceptions $exceptions) {
    })
    ->create();