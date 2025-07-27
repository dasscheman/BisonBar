<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

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
        Blade::directive('currency', function ($money) {
            return currency($money);
        });

        Gate::define('admin', function () {
            if(!Auth::check()){
                return false;
            }
            $user = Auth::user();
            if($user->role_id == User::ROLE_admin || $user->role_id == User::ROLE_super_admin) {
                return true;
            }
            return false;
        });
    }
}
