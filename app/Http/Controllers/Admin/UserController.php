<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Symfony\Component\HttpFoundation\StreamedResponse;

class UserController extends Controller
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
        ->select('id', 'name', 'tel','email','memo')
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

    public function store(StoreUserRequest $request)
    {
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

        return to_route('admin.users.index', [
            'user_id' => $user->id
        ])

        ->with([
            'message' => '登録しました。',
            'status' => 'success'
        ]);
    }

    public function show(User $user)
    {
        return Inertia::render('Admin/Users/Show', [
            'user' => $user
        ]);
    }

    public function edit(User $user)
    {
        return Inertia::render('Admin/Users/Edit', [
            'user' => $user
        ]);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->name = $request->name;
        $user->email = $request->email;
        $user->memo = $request->memo;
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

    public function destroy(User $user)
    {
        $user->delete();

        return to_route('admin.users.index')
        ->with([
            'message' => '削除しました。',
            'status' => 'danger'
        ]);
    }

    public function expiredUserIndex()
    {
        $expiredUsers = User::onlyTrashed()->paginate(10);

        return Inertia::render('Admin/Users/Expired', [
            'expiredUsers' => $expiredUsers
        ]);
    }

    public function expiredUserDestroy($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        // findOrFail 一致するidが見つからなかった場合は、エラー404を返すa

        // 関連する todos も完全削除
        $user->todos()->forceDelete();

        // ユーザーを完全削除
        $user->forceDelete();

        return redirect()->route('admin.expired-users.index')
        ->with([
            'message' => '完全に削除しました。',
            'status' => 'danger'
        ]);
    }

    public function export()
    {
        $fileName = 'users.csv';

        $headers = [
            "Content-Type" => "text/csv; charset=Shift_JIS",
            // Shift_JISを指定
            // CSVファイルとして扱うことを指定
            "Content-Disposition" => "attachment; filename={$fileName}",
            // ダウンロード時のファイル名を指定
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');

            $header = [
                'ID',
                '生徒名',
                '生徒名(カナ)',
                '電話番号',
                'メールアドレス',
                '郵便番号',
                '住所',
                '誕生日',
                '備考',
                '登録日',
            ];
            // CSVの1行を出力するPHPの関数。最初にヘッダーを出力
            mb_convert_variables('SJIS-win', 'UTF-8', $header);
            fputcsv($file, $header);

             // チャンクを使ってデータを分割取得
            User::chunk(10000, function ($users) use ($file) {
                foreach ($users as $user) {
                    $users_data = [
                        $user->id,
                        $user->name,
                        $user->kana,
                         // 明示的に文字列化
                        '"' . $user->tel . '"',
                        $user->email,
                        $user->postcode,
                        $user->address,
                        $user->birthday,
                        $user->memo,
                        $user->created_at,
                    ];
                    // 文字コード変換
                    mb_convert_variables('SJIS-win', 'UTF-8', $users_data);

                    fputcsv($file, $users_data);
                }
            });
            fclose($file);
        };
        return new StreamedResponse($callback, 200, $headers);
    }
}
