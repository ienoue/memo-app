@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            右側パネル
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('create') }}">
                @csrf
                <div class="mb-3">
                    <textarea name="content" class="form-control" rows="3" placeholder="テキストを入力して下さい"></textarea>
                </div>
                <div class="mb-3">
                    <input name="tag" type="text" class="form-control" placeholder="新しいタグを入力">
                </div>
                <button type="submit" class="btn btn-primary mb-3">新規作成</button>
            </form>
        </div>
    </div>
@endsection
