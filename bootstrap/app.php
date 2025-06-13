<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        // api: __DIR__.'/../routes/api.php', // 🗑️ HAPUS BARIS INI
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // 🎯 Registrasi middleware alias di sini
        $middleware->alias([
            'seller.auth' => \App\Http\Middleware\SellerAuthMiddleware::class,
            'buyer.auth' => \App\Http\Middleware\BuyerAuthMiddleware::class,
            'auth.check' => \App\Http\Middleware\AuthCheckMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();