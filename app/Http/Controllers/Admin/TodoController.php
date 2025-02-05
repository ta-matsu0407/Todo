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
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $todos = Todo::with('user')
        ->searchTodos($request->search)
        ->paginate(10);
        //　user_id から 関連する User の情報 を一緒に取得
        // これにより、Vue 側で todo.user.name のように ユーザーの名前を表示できる
        // dd($todos);
        // logger($todos);
        return Inertia::render('Admin/Todos/Index', [
            'todos' => $todos
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::select('id', 'name')->get();

        return Inertia::render('Admin/Todos/Create', [
            'users' => $users
        // 作成した変数をvue側に渡す
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTodoRequest $request)
    {
        // dd($request->all());
        // データを保存
        Todo::create([
            'user_id' => $request->user_id,
            'homework' => $request->homework,
            'memo' => $request->memo,
            'status' => '1', // デフォルトで "未完了" に設定
            'deadline' => $request->deadline,
        ]);

        // 一覧ページにリダイレクト
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
        // dd($todo);
        $todo->load('user');

        return Inertia::render('Admin/Todos/Show', [
            'todo' => $todo
        ]);
    }

    // public function show($id)
    // {

    //     $todo = Todo::with('user')->findOrFail($id);

    //     return Inertia::render('Admin/Todos/Show', [
    //         'todo' => $todo
    //     ]);
    // }


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

    /**
     * Update the specified resource in storage.
     */
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

    /**
     * Remove the specified resource from storage.
     */
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
