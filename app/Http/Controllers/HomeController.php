<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Memo;
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
    public function index()
    {
        return view('home');
    }

    public function delete(Request $request)
    {
        Memo::where('id', $request->id)->where('user_id', Auth::id())->delete();
        return redirect('/home');
    }

    public function create(Request $request)
    {
        $memo = new Memo();
        $form = $request->all();
        unset($form['_token']);
        $memo->user_id = Auth::id();
        $memo->fill($form)->save();
        return redirect('/home');
    }

    public function edit($id)
    {
        $item = Memo::where('id', $id)->where('user_id', Auth::id())->first();
        return view('edit', compact('item', 'id'));
    }
}
