@extends('layouts.app')

@section('content')
    <div class="card disp-height">
        <div class="card-header">
            新規メモ作成
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('create') }}">
                @csrf
                <div class="mb-5">
                    <textarea name="content" class="form-control mb-2" rows="3" placeholder="テキストを入力して下さい"></textarea>
                    @error('content')
                        <div class="alert alert-danger" role="alert">
                            テキストが入力されていません。
                        </div>
                    @enderror
                </div>

                <h6 class="card-subtitle mb-3 text-muted">タグ一覧</h6>
                <div class="mb-4">
                    @foreach ($tags as $tag)
                        <div class="form-check form-check-inline mb-3">
                            <input class="form-check-input" type="checkbox" name="tags[]" id="tag-{{ $tag->id }}"
                                value="{{ $tag->id }}">
                            <label class="form-check-label" for="tag-{{ $tag->id }}">{{ $tag->name }}</label>
                        </div>
                    @endforeach
                </div>
                <div class="mb-3">
                    <input name="tag" type="text" class="form-control mb-4" placeholder="新しいタグを入力">
                    @error('tag')
                        <div class="alert alert-danger" role="alert">
                            スペース以外の文字を入力して下さい。
                        </div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary mb-3">新規作成</button>
            </form>
        </div>
    </div>
@endsection
