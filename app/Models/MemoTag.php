<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemoTag extends Model
{
    use HasFactory;
    protected $fillable = ['tag_id', 'memo_id'];

    public function memo()
    {
        return $this->belongsTo(Memo::class);
    }

    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }
}
