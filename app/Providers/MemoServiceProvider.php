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
                $memos = Memo::getQueryOfAllByTag($tagID);
            } else {
                $memos = Memo::getQueryOfAll();
            }

            $tags = Tag::getQueryOfAll();
            $view->with([
                'memos' => $memos->get(),
                'tags' => $tags->get(),
                'memosPaginate' => $memos->simplePaginate($perPage = 10, $columns = ['*'], $pageName = 'memos'),
                'tagsPaginate' => $tags->simplePaginate($perPage = 10, $columns = ['*'], $pageName = 'tags'),
            ]);
        });
    }
}
