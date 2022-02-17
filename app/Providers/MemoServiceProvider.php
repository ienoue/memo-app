<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Memo;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;

class MemoServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(['home', 'edit'], function ($view) {
            $memosQuery = Memo::where('user_id', Auth::id())
                ->orderBy('memos.updated_at', 'desc');
            // URLにtagクエリパラメータが設定してあった場合、memosテーブルをtag_idで絞り込む
            $tagID = request()->input('tag');
            if (isset($tagID)) {
                $memosQuery = $memosQuery
                    ->join('memo_tags', 'memos.id', '=', 'memo_tags.memo_id')
                    ->where('memo_tags.tag_id', $tagID);
            }
            $memos = $memosQuery->get();

            $tags = Tag::where('user_id', Auth::id())
                ->orderBy('updated_at', 'desc')
                ->get();
            $view->with([
                'memos' => $memos,
                'tags' => $tags
            ]);
        });
    }
}
