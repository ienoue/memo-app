<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Memo;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;

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
    public function index(Request $request)
    {
        return view('home');
    }

    public function delete(Request $request)
    {
        $memo = Memo::where('id', $request->id)
            ->where('user_id', Auth::id())
            ->first();
        $memo->tags()->detach();
        $memo->delete();
        return redirect('/home');
    }

    public function create(Request $request)
    {
        $validate_rule = [
            'content' => 'required|not_regex:/^[ 　]+$/',
            'tag' => 'not_regex:/^[ 　]+$/',
        ];
        $this->validate($request, $validate_rule);
        Memo::saveMemoWithTags();
        return redirect('/home');
    }

    public function edit(Request $request, $id)
    {
        $memo = Memo::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();
        if(!isset($memo)) {
            return redirect('/home');
        } 
        $memoTags = $memo->tags()->pluck('id');
        return view('edit', compact('memo', 'id', 'memoTags'));
    }

    public function update(Request $request)
    {
        $validate_rule = [
            'content' => 'required|not_regex:/^[ 　]+$/',
            'tag' => 'not_regex:/^[ 　]+$/',
        ];
        $this->validate($request, $validate_rule);
        Memo::saveMemoWithTags();
        return redirect()->route('edit', ['id' => $request->id]);
    }
}
