<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Buyer;
use App\Models\Seller;

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
    public function boot(): void
    {
            view()->composer('*', function ($view) {
        $user = null;
        $role = session('role');
        $userId = session('user_id');

        if ($role === 'buyer') {
            $user = Buyer::find($userId);
        } elseif ($role === 'seller') {
            $user = Seller::find($userId);
        }

        $view->with('user', $user);
    });
    }
}
