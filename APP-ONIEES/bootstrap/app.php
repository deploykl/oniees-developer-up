<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // 👇 Permitir CORS para Vite
        $middleware->trustHosts(['172.27.0.150', 'localhost', '127.0.0.1']);
        $middleware->trustProxies(at: '*');
        
        // 👇 Configurar CORS
        $middleware->validateCsrfTokens(except: [
            '*',  // Para desarrollo (opcional)
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();