<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Models\Buyer;
use App\Models\Seller;
use App\Services\ExpService;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register ExpService as a singleton
        $this->app->singleton(ExpService::class, function ($app) {
            return new ExpService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
{
        // Use Bootstrap 4 pagination views
        Paginator::useBootstrapFour();

        // Share user data to all views based on session role
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