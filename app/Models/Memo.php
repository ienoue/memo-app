<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Memo extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['content', 'user_id'];

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'memo_tags')->withTimestamps();;
    }
}
