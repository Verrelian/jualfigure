<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Models\Buyer;
use App\Models\Seller;
use App\Services\ExpService;

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
    public function boot(): void
    {
        // Use Bootstrap 4 pagination views
        Paginator::useBootstrapFour();

        // Share user data to all views based on session role
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
