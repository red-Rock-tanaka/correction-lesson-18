<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['contents', 'user_name']; // user_nameをfillableに追加

    // ユーザーとのリレーションを定義
    public function user()
    {
        return $this->belongsTo(User::class, 'user_name', 'name'); // user_nameを使ってUserモデルと関連付け
    }
}
