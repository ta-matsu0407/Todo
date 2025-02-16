<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Inertia\Inertia;
use App\Http\Requests\StoreTodoRequest;
use App\Http\Requests\UpdateTodoUserRequest;
use App\Http\Requests\UpdateTodoStatusRequest;
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

    public function show(Todo $todo)
    {
        // dd($todo);
        $todo->load('user');

        return Inertia::render('User/Todos/Show', [
            'todo' => $todo
        ]);
    }

    public function edit(Todo $todo)
    {
        $todo->load('user');

        return Inertia::render('User/Todos/Edit', [
            'todo' => $todo
        ]);
    }

    public function update(UpdateTodoUserRequest $request, Todo $todo)
    {
        $todo->homework = $request->homework;
        $todo->deadline = $request->deadline;
        $todo->memo = $request->memo;
        $todo->save();

        return to_route('todos.index')
        ->with([
            'message' => '更新しました。',
            'status' => 'success'
        ]);

    }

    public function destroy(Todo $todo)
    {
        $todo->delete();

        return to_route('todos.index')
        ->with([
            'message' => '削除しました。',
            'status' => 'danger'
        ]);
    }


    // Todoのステータスを変更

    public function updateStatus(UpdateTodoStatusRequest $request, Todo $todo)
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
