<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return Inertia::render('User/Dashboard', [
            'user' => $user
        ]);
    }

    public function edit(User $user)
    {
        return Inertia::render('User/Edit', [
            'user' => $user
        ]);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $request->validate([
            'status' => ['required'],
            'memo' => ['required'],
        ]);

        $user->update([
            'status' => $request->status,
            'memo' => $request->memo,
        ]);

        return to_route('dashboard')
        ->with([
            'message' => '更新しました。',
            'status' => 'success'
        ]);
    }
}
