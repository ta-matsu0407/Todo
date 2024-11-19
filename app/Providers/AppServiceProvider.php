<?php

namespace App\Providers;

use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

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
        if (request()->is('admin*')) {
            // 管理画面用のセッションクッキーを設定
            config(['session.cookie' => config('session.cookie_admin')]);
        } else {
            // 一般ユーザー用のセッションクッキーを設定
            config(['session.cookie' => config('session.cookie')]);
        }
    }
}
