<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Buyer;
use App\Models\Seller;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
{
    View::composer('*', function ($view) {
        $role = session('role');
        $userId = session('user_id');

        if ($role === 'buyer') {
            $user = Buyer::find($userId);
        } elseif ($role === 'seller') {
            $user = Seller::find($userId);
        } else {
            $user = null;
        }

        $view->with('user', $user); // sekarang $user bisa dipakai di semua Blade
    });
}
}