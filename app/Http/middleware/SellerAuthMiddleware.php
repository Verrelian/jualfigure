<?php
// app/Http/Middleware/SellerAuthMiddleware.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SellerAuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (session('role') !== 'seller' || !session('user_id')) {
            return redirect()->route('login')->with('error', 'Akses ditolak. Halaman ini khusus untuk seller.');
        }

        return $next($request);
    }
}