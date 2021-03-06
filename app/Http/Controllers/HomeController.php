<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Memo;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\MemoRequest;

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
        Memo::deleteMemoWithTags();
        return redirect('/home');
    }

    public function create(MemoRequest $request)
    {
        Memo::saveMemoWithTags();
        return redirect('/home');
    }

    public function edit(Request $request, $id)
    {
        $memo = Memo::getMemo($id);
        if(!isset($memo)) {
            return redirect('/home');
        } 
        $memoTags = $memo->tags()->pluck('id');
        return view('edit', compact('memo', 'id', 'memoTags'));
    }

    public function update(MemoRequest $request)
    {
        Memo::saveMemoWithTags();
        return redirect()->route('edit', ['id' => $request->id]);
    }
}
