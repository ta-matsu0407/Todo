<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use App\Models\User; //Eloquent
use Illuminate\Support\Facades\DB; //QueryBuilder
use Carbon\Carbon;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // public function __construct()
    // {
    //     $this->middleware('auth:admins');
    // }

    public static function middleware(): array
    {
        return [
            'auth',
        ];
    }

    public function index()
{

    return Inertia::render('Admin/Users/Index', [
        'users' =>User::select('id', 'name', 'email')
        ->get()
        //selectを使う場合は、getが必要。getでデータの内容が確定する。

        //User::all()
        //第二引数で連想配列で渡す。変数は複数形で。モデル名::allでテーブル全てのデータを取得。→取得するデータをselectで絞った方が良い。
    ]);

    // Log::info('デバッグ中: リクエストを受信しました');

    // return Inertia::render('DebugPage', [
    //     'message' => 'デバッグ中',
    // ]);
}
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
