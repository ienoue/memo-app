<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;


class Tag extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['name', 'user_id'];

    public function memos()
    {
        return $this->belongsToMany(Memo::class, 'memo_tags')->withTimestamps();;
    }

    public static function getAll(){
        return self::where('user_id', Auth::id())
        ->orderBy('updated_at', 'desc')
        ->get();
    }
}
