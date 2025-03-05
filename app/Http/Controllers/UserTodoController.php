<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Inertia\Inertia;
use App\Http\Requests\StoreTodoRequest;
use App\Http\Requests\UpdateTodoUserRequest;
use App\Http\Requests\UpdateTodoStatusRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UserTodoController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    // ログインユーザーのIDを取得
    $userId = (int) Auth::user()->id;

    $todos = Todo::with('user')
                ->where('user_id', $userId)
                ->latest()
                ->paginate(10);

        return Inertia::render('User/Todos/Index', [
            'todos' => $todos
        ]);
    }

    public function create()
    {
        $userId = (int) Auth::user()->id;

        return Inertia::render('User/Todos/Create');
    }

    public function store(StoreTodoRequest $request)
    {
        Todo::create([
            'user_id' => Auth::id(),
            'homework' => $request->homework,
            'deadline' => $request->deadline,
            'memo' => $request->memo,
            'status' => '1',
            'created_by_type' => 'user', // 固定
        ]);

        return to_route('todos.index')
        ->with([
            'message' => '登録しました。',
            'status' => 'success'
        ]);
    }

    public function show(Todo $todo)
    {
        $this->authorize('view', $todo); // Policy による権限チェック

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
