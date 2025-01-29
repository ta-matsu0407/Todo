<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\UserDashboardController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Route::get('/dashboard', [UserController::class, 'show'])->name('user.show');

// Route::middleware(['auth:users', 'verified'])->group(function () {
//     Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
// });

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth:users', 'verified'])->name('dashboard');

// Route::middleware('auth:users')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

// 認証が必要なルートをまとめる
Route::middleware(['auth:users', 'verified'])->group(function () {

    // カスタマイズしたユーザーダッシュボードへのルート
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::get('/edit/{user}', [UserDashboardController::class, 'edit'])->name('user.edit');
    Route::put('/edit/{user}', [UserDashboardController::class, 'update'])->name('user.update');


    // プロフィール編集関連のルート
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('todos', TodoController::class)
->middleware('auth:users', 'verified');


require __DIR__.'/auth.php';
