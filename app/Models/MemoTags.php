<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemoTags extends Model
{
    use HasFactory;

    public function memo()
    {
        $this->belongsTo(Memo::class);
    }

    public function tag()
    {
        $this->belongsTo(Tag::class);
    }
}
