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
            // URLにtagクエリパラメータが設定してあった場合、memosテーブルをtag_idで絞り込む
            $tagID = request()->input('tag');
            if (isset($tagID)) {
                $memos = Memo::getAllByTag($tagID);
            } else {
                $memos = Memo::getAll();
            }

            $tags = Tag::getAll();
            $view->with([
                'memos' => $memos,
                'tags' => $tags
            ]);
        });
    }
}
