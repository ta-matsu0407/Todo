<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\TodoController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::resource('users', UserController::class)
->middleware('auth:admins', 'verified');

Route::prefix('expired-users')->
    middleware('auth:admins')->group(function(){
        Route::get('index', [UserController::class,'expiredUserIndex'])->name('expired-users.index');
        Route::delete('destroy/{expiredUser}',[UserController::class, 'expiredUserDestroy'])->name('expired-users.destroy');
});

Route::resource('todos', TodoController::class)
->middleware('auth:admins', 'verified');

Route::get('/dashboard', function () {
    return Inertia::render('Admin/Dashboard');
})->middleware(['auth:admins', 'verified'])->name('dashboard');

Route::middleware('auth:admins')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('admin/users/export', [UserController::class, 'export'])->middleware('auth:admins', 'verified')->name('users.export');

require __DIR__.'/adminAuth.php';
