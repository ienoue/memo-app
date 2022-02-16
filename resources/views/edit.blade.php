@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            右側パネル
            <form action="{{ route('delete') }}" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{ $id }}">
                <button>削除</button>
            </form>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('update') }}">
                @csrf
                <div class="mb-3">
                    <input type="hidden" name="id" value="{{ $id }}">
                    <textarea name="content" class="form-control" rows="3" placeholder="テキストを入力して下さい">{{ $memo->content }}</textarea>
                </div>
                <div class="mb-3">
                    <input name="tag" type="text" class="form-control" placeholder="新しいタグを入力">
                </div>

                <button type="submit" class="btn btn-primary mb-3">更新</button>
            </form>
        </div>
    </div>
@endsection
