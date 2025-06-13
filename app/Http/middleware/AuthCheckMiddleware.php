<?php

// app/Http/Middleware/AuthCheckMiddleware.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthCheckMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!session('user_id') || !session('role')) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        return $next($request);
    }
}