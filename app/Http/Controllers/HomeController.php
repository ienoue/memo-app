<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Memo;
use App\Models\Tag;
use App\Models\MemoTag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $memos = Memo::where('user_id', Auth::id())
            ->orderBy('updated_at', 'desc')
            ->get();

        $tags = Tag::where('user_id', Auth::id())
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('home', compact('memos', 'tags'));
    }

    public function delete(Request $request)
    {
        Memo::where('id', $request->id)
            ->where('user_id', Auth::id())
            ->delete();
        return redirect('/home');
    }

    public function create(Request $request)
    {
        DB::transaction(
            function () use ($request) {
                $memo = Memo::create([
                    'user_id' => Auth::id(),
                    'content' => $request->content,
                ]);

                $tagName = $request->tag;
                $tags = $request->tags;
                // タグIDの配列が文字列から数値にキャストしておく、タグがチェックされて無ければ新規作成
                $tags = isset($tags) ? array_map('intval', $request->tags) : [];
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
        return redirect('/home');
    }

    public function edit($id)
    {
        $memos = Memo::where('user_id', Auth::id())
            ->orderBy('updated_at', 'desc')
            ->get();

        $memo = Memo::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        $tags = Tag::where('user_id', Auth::id())
            ->orderBy('updated_at', 'desc')
            ->get();

        $memoTags = $memo->tags()->pluck('id');
        // dd($memoTags);
        return view('edit', compact('memos', 'memo', 'id', 'tags', 'memoTags'));
    }

    public function update(Request $request)
    {
        DB::transaction(
            function () use ($request) {
                $memo = Memo::where('id', $request->id)
                    ->where('user_id', Auth::id())
                    ->first();
                $memo->content = $request->content;
                $memo->save();

                $tagName = $request->tag;
                $tags = $request->tags;
                // タグIDの配列を文字列から数値にキャストしておく、タグがチェックされて無ければ新規作成
                $tags = isset($tags) ? array_map('intval', $request->tags) : [];
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

        return redirect()->route('edit', ['id' => $request->id]);
    }
}
