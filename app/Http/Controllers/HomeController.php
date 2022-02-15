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
        return view('home', compact('memos'));
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

                $tag = Tag::create([
                    'user_id' => Auth::id(),
                    'name' => $request->tag,
                ]);

                MemoTag::create([
                    'memo_id' => $memo->id,
                    'tag_id' => $tag->id,
                ]);

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

        return view('edit', compact('memos', 'memo', 'id'));
    }

    public function update(Request $request)
    {

        $memo = Memo::where('id', $request->id)
            ->where('user_id', Auth::id())
            ->first();
        $form = $request->all();
        unset($form['_token']);
        $memo->user_id = Auth::id();
        $memo->fill($form)->save();

        return redirect()->route('edit', ['id' => $request->id]);
    }
}
