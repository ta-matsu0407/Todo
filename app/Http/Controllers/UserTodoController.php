<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Inertia\Inertia;
use App\Http\Requests\StoreTodoRequest;
use App\Http\Requests\UpdateTodoUserRequest;
use Illuminate\Support\Facades\Auth;


class UserTodoController extends Controller
{
    public function index()
    {
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
        ]);

        return to_route('todos.index')
        ->with([
            'message' => '登録しました。',
            'status' => 'success'
        ]);
    }

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
