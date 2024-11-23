<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Log;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): Response
    {
        return Inertia::render('Admin/Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate(); //セッション情報を再発行

        //Log::debug('admin:', $request->session()->all()); //デバック:セッション情報を全て確認

        return redirect()->intended(route('admin.dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {

        // デバッグ用のコード
        // dd([
        //     'current_guard' => Auth::getDefaultDriver(), // 現在使用されているデフォルトのガード名
        //     'guards_config' => config('auth.guards'),   // 設定されている全てのガード
        //     'admins_guard_check' => Auth::guard('admins')->check(), // admins ガードが機能しているか
        //     'current_user' => Auth::guard('admins')->user(), // admins ガードで認証されたユーザー情報
        // ]);

        Auth::guard('admins')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }
}
