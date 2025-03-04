<?php

namespace App\Providers;

use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use App\Policies\TodoPolicy;
use App\Models\Todo;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //コードを見たとき「このメソッドは何も返さない」と分かりやすくするために"void"を使用している
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        // userから始まるURL
        if (request()->is('user*')) {
            config(['session.cookie' => config('session.cookie_user')]);
        }
        // adminから始まるURL
        if (request()->is('admin*')) {
            config(['session.cookie' => config('session.cookie_admin')]);
        }
    }

    protected $policies = [
        Todo::class => TodoPolicy::class,
        // Policyを登録
    ];
}
