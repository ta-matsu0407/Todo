<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use App\Models\User;
use App\Models\Todo;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Throwable;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public static function middleware(): array
    {
        return [
            'auth',
        ];
    }

    public function index(Request $request)
    {
        $users = User::searchUsers($request->search)
        ->select('id', 'name', 'memo','status')
        ->paginate(10);

        return Inertia::render('Admin/Users/Index', [
            'users' => $users
        ]);
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
            'name' => ['required', 'max:50'],
            'kana' => ['required', 'regex:/^[ァ-ヾ]+$/u','max:50'],
            'tel' => ['required', 'max:20', 'unique:users,tel'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'postcode' => ['required', 'max:7'],
            'address' => ['required', 'max:100'],
            'birthday' => ['date'],
            'gender' => ['required'],
            'password' => ['required'],
            'memo' => ['max:1000'],
        ]);

        try{
            DB::transaction(function() use($request) {
                $user = User::create([
                    'name' => $request->name,
                    'kana' => $request->kana,
                    'tel' => $request->tel,
                    'email' => $request->email,
                    'postcode' => $request->postcode,
                    'address' => $request->address,
                    'birthday' => $request->birthday,
                    'gender' => $request->gender,
                    'password' => $request->password,
                    'memo' => $request->memo,
                ]);

                Todo::create([
                    'user_id' => $user->id,
                    'title' => 'タイトルを入力して下さい。',
                    'memo' => '',
                    'status' => '1',
                    'due_date' => '2000/2/22',
                ]);
            }, 1);
        }catch(Throwable $e){
            Log::error($e);
            throw $e;
        }

        return to_route('admin.users.index')
        ->with([
            'message' => '登録しました。',
            'status' => 'success'
        ]);
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

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->memo = $request->memo;
        $user->status = $request->status;
        $user->kana = $request->kana;
        $user->tel = $request->tel;
        $user->postcode = $request->postcode;
        $user->address = $request->address;
        $user->birthday = $request->birthday;
        $user->gender = $request->gender;
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
