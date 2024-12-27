<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Todo;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'kana',
        'tel',
        'email',
        'postcode',
        'address',
        'birthday',
        'gender',
        'password',
        'memo',
        'status',
    ];
    //コントローラ側 create() で保存できるように$fillableを設定
    //複数代入の脆弱性から保護するために必要

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function scopeSearchUsers($query, $input = null)
    // 関数名の頭は"scope"、第一引数は"$query"、第二引数は入力された文字、
    // controllerで、searchUsersとして使える

    {
        if (!empty($input)) {
            // 状況 (status) に該当する値で検索
            if (in_array($input, ['実施', '完了'])) {
                return $query->where('status', $input);
            }

            // 状況に該当しない場合は kana で検索
            return $query->where('kana', 'like', $input . '%');
        }

        return $query; // 入力がない場合はそのまま返す
    }

    public function todo()
    {
        return $this->hasMany(Todo::class);
        // hasOne：１対１
        // hasMany：１対多
    }
}
