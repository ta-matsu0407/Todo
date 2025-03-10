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
    {
        if (!empty($input)) {
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
