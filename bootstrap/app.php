<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\AdminMiddleware; //Panggil middleware disini

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    // Menambahkan middleware ke aplikasi
    ->withMiddleware(function (Middleware $middleware) {
       
        $middleware->alias([
            'admin' => AdminMiddleware::class, // Daftarkan middleware admin
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
