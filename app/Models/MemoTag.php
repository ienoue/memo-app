<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemoTag extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['tag_id', 'memo_id'];

    public function memo()
    {
        $this->belongsTo(Memo::class);
    }

    public function tag()
    {
        $this->belongsTo(Tag::class);
    }
}
