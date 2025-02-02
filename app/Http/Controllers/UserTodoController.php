<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Inertia\Inertia;
use App\Http\Requests\StoreTodoRequest;
use App\Http\Requests\UpdateTodoUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class UserTodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // ログインユーザーのIDを取得
    $userId = (int) Auth::user()->id;

    // 自分のTodoリストを取得（最新順 & ページネーション)
    // with('user') を使って user の情報も取得
    $todos = Todo::with('user')
                ->where('user_id', $userId)
                ->latest()
                ->paginate(10);

    // dd($todos->toArray());

        return Inertia::render('User/Todos/Index', [
            'todos' => $todos
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $userId = (int) Auth::user()->id;

        return Inertia::render('User/Todos/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTodoRequest $request)
    {
        // dd($request->all());

        Todo::create([
            'user_id' => Auth::id(), // ログインしているユーザーのIDを保存
            'homework' => $request->homework,
            'deadline' => $request->deadline,
            'memo' => $request->memo,
            'status' => '1',
        ]);

        return to_route('todos.index')
        ->with([
            'message' => '登録しました。',
            'status' => 'success'
        ]);
    }

    // Todoのステータスを変更

    public function updateStatus(UpdateTodoUserRequest $request, Todo $todo)
    {
        $todo->update([
            'status' => $request->status
        ]);

        return to_route('todos.index')
        ->with([
            'message' => '更新しました。',
            'status' => 'success'
        ]);
    }

}
