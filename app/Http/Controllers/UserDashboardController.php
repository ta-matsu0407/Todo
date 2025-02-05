<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateUserDashboardRequest;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class UserDashboardController extends Controller
{
    public function index()
    {
        // ログイン中のユーザー情報を取得
        $user = Auth::user();

        return Inertia::render('User/Dashboard', [
            'user' => $user
        ]);
    }

    // public function edit(User $user)
    // {
    //     if (Gate::denies('view', $user)) {
    //         abort(403, 'Unauthorized action.');
    //     }

    //     return Inertia::render('User/Edit', [
    //         'user' => $user
    //     ]);
    // }

    // public function update(UpdateUserDashboardRequest $request, User $user)
    // {
        // dd($user, $request);

        // $request->validate([
        //     'status' => ['required'],
        //     'memo' => ['required'],
        // ]);

        // dd($user->name, $request->name);
        // $user->name...現在の情報
        // $request->name...新しい情報

        // $user->status = $request->status;
        // $user->memo = $request->memo;
        // $user->save();

        // $user->update([
        //     'status' => $request->status,
        //     'memo' => $request->memo,
        // ]);
        // save()だと一括更新してしまう。
        // 必須項目がblankになってしまうので、updateメソッドで更新項目を指定する。

        // return to_route('dashboard')
        // ->with([
        //     'message' => '更新しました。',
        //     'status' => 'success'
        // ]);
    // }
}
