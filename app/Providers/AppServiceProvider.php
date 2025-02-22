<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        if (request()->is('user*')) {
            config(['session.cookie' => config('session.cookie_user')]);
        }
        if (request()->is('admin*')) {
            config(['session.cookie' => config('session.cookie_admin')]);
        }
    }
}
