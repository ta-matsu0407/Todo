<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Todo;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\StoreTodoRequest;
use App\Http\Requests\UpdateTodoRequest;


class TodoController extends Controller
{
    public function index(Request $request)
    {
        $todos = Todo::with('user')
        ->searchTodos($request->search)
        ->paginate(10);

        return Inertia::render('Admin/Todos/Index', [
            'todos' => $todos
        ]);
    }

    public function create()
    {
        $users = User::select('id', 'name')->get();

        return Inertia::render('Admin/Todos/Create', [
            'users' => $users
        ]);
    }

    public function store(StoreTodoRequest $request)
    {
        Todo::create([
            'user_id' => $request->user_id,
            'homework' => $request->homework,
            'memo' => $request->memo,
            'status' => '1', // デフォルトで "未完了" に設定
            'deadline' => $request->deadline,
            'created_by_type' => 'admin', // 固定
        ]);

        return to_route('admin.todos.index')
        ->with([
            'message' => '登録しました。',
            'status' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Todo $todo)
    {
        $todo->load('user');

        return Inertia::render('Admin/Todos/Show', [
            'todo' => $todo
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Todo $todo)
    {
        $todo->load('user');

        return Inertia::render('Admin/Todos/Edit', [
            'todo' => $todo
        ]);
    }

    public function update(UpdateTodoRequest $request, Todo $todo)
    {
        $todo->homework = $request->homework;
        $todo->deadline = $request->deadline;
        $todo->status = $request->status;
        $todo->memo = $request->memo;
        $todo->save();

        return to_route('admin.todos.index')
        ->with([
            'message' => '更新しました。',
            'status' => 'success'
        ]);

    }

    public function destroy(Todo $todo)
    {
        $todo->delete();

        return to_route('admin.todos.index')
        ->with([
            'message' => '削除しました。',
            'status' => 'danger'
        ]);
    }
}
