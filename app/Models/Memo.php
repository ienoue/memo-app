<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Memo extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['content', 'user_id'];

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'memo_tags')->withTimestamps();;
    }

    public static function saveMemoWithTags()
    {
        DB::transaction(
            function () {
                if (Request::routeIs('create')) {
                    $memo = Memo::createMemo();
                } else {
                    $memo = Memo::updateMemo();
                }
                $tagName = Request::get('tag');
                $tags = Request::get('tags');
                // タグIDの配列が文字列から数値にキャストしておく、タグがチェックされて無ければ新規作成
                $tags = isset($tags) ? array_map('intval', Request::get('tags')) : [];
                // フォームにタグが入力されていた場合の処理
                if (isset($tagName)) {
                    $tag = Tag::where('name', $tagName)->first();
                    // タグが未作成のものだった場合の処理
                    if (!isset($tag)) {
                        $tag = Tag::create([
                            'user_id' => Auth::id(),
                            'name' => $tagName,
                        ]);
                    }
                    $tags[] = $tag->id;
                }
                $memo->tags()->sync($tags);
            }
        );
    }

    public static function createMemo()
    {
        return self::create([
            'user_id' => Auth::id(),
            'content' => Request::get('content'),
        ]);
    }

    public static function updateMemo()
    {
        $memo = self::where('id', Request::get('id'))
            ->where('user_id', Auth::id())
            ->first();
        $memo->content = Request::get('content');
        $memo->save();
        return $memo;
    }
}
