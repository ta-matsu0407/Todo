<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class Todo extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'homework',
        'memo',
        'status',
        'deadline',
        'created_by_type'
    ];

    public function scopeSearchTodos($query, $input = null)
    // 関数名の頭は"scope"、第一引数は"$query"、第二引数は入力された文字、
    // controllerで、searchUsersとして使える
    // 第一引数の $query は、検索対象となるデータの「クエリ」を受け取る。
    // 第二引数の $input は、「検索キーワード」を受け取る。（何も入力されていなければ null）

    {
        if (!empty($input)) {
            // $input が 空でないかチェック
            // 検索ワードが入力されている場合だけ、検索処理を実行
            // 状況 (status) に該当する値で検索
            if (in_array($input, ['実施', '完了'])) {
                return $query->where('status', $input);
            }

            // 状況に該当しない場合は name で検索
            // return $query->where('name', 'like', $input . '%');
            return $query->orWhereHas('user', function ($q) use ($input) {
                $q->where('name', 'like', '%' . $input . '%');
            });

        }

        return $query; // 入力がない場合はそのまま返す
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
