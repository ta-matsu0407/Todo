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
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

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

    // $getTest = User::select('id', 'name', 'memo','status')->get();
    // $getPaginateTest = User::select('id', 'name', 'memo','status')->paginate(10);
    // vue側に受け渡す型が異なる、propsでの受け取り方に注意

    // dd($getTest, $getPaginateTest);

    return Inertia::render('Admin/Users/Index', [
        'users' =>User::select('id', 'name', 'memo','status')
        ->paginate(10)
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
        return Inertia::render('Admin/Users/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {

        $request->validate([
            'name' => ['required'],
            'email' => ['required'],
            'password' => ['required'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'memo' => $request->memo,
        ]);

        return to_route('admin.users.index')
        ->with([
            'message' => '登録しました。',
            'status' => 'success'
        ]);
        // リダイレクト処理に続けて、->withでフラッシュメッセージ
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return Inertia::render('Admin/Users/Show', [
            'user' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        // dd($user);
        return Inertia::render('Admin/Users/Edit', [
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $request->validate([
            'name' => ['required'],
            'email' => ['required'],
            'password' => ['required'],
        ]);

        // dd($user->name, $request->name);
        // $user->name...現在の情報
        // $request->name...新しい情報

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->memo = $request->memo;
        $user->save();

        return to_route('admin.users.index')
        ->with([
            'message' => '更新しました。',
            'status' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return to_route('admin.users.index')
        ->with([
            'message' => '削除しました。',
            'status' => 'danger'
        ]);
    }
}
