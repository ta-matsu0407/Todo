<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return Inertia::render('User/Dashboard', [
            'user' => $user
        ]);
    }
}
