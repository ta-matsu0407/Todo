<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\UserTodoController;
use App\Http\Controllers\UserDashboardController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// 認証が必要なルートをまとめる
Route::middleware(['auth:users', 'verified'])->group(function () {

    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');

    // プロフィール編集関連のルート
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('todos', UserTodoController::class)
    ->middleware('auth:users', 'verified');

Route::patch('/todos/{todo}/status', [UserTodoController::class, 'updateStatus'])
    ->name('user.todos.updateStatus')
    ->middleware('auth');

require __DIR__.'/auth.php';
