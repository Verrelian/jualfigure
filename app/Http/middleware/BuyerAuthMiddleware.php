<?php
// app/Http/Middleware/BuyerAuthMiddleware.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class BuyerAuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (session('role') !== 'buyer' || !session('user_id')) {
            return redirect()->route('login')->with('error', 'Akses ditolak. Halaman ini khusus untuk buyer.');
        }

        return $next($request);
    }
}
