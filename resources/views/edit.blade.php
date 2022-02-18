@extends('layouts.app')
    
@section('javascript')
    <script src="/js/memo.js"></script>
@endsection

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between me-3">
            メモ編集
            <form name="deleteForm" action="{{ route('delete') }}" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{ $id }}">
                <i role="button" onclick="deleteMemo(event);" class="fa-solid fa-trash link-primary"></i>
            </form>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('update') }}">
                @csrf
                <div class="mb-3">
                    <input type="hidden" name="id" value="{{ $id }}">
                    <textarea name="content" class="form-control mb-2" rows="3"
                        placeholder="テキストを入力して下さい">{{ $memo->content }}</textarea>
                    @error('content')
                        <div class="alert alert-danger" role="alert">
                            テキストが入力されていません。
                        </div>
                    @enderror

                </div>
                @foreach ($tags as $tag)
                    <div class="form-check form-check-inline mb-3">
                        <input class="form-check-input" type="checkbox" name="tags[]" id="tag-{{ $tag->id }}"
                            value="{{ $tag->id }}" {{ $memoTags->contains($tag->id) ? 'checked' : '' }}>
                        <label class="form-check-label" for="tag-{{ $tag->id }}">{{ $tag->name }}</label>
                    </div>
                @endforeach
                <div class="mb-3">
                    <input name="tag" type="text" class="form-control mb-2" placeholder="新しいタグを入力">
                    @error('tag')
                        <div class="alert alert-danger" role="alert">
                            スペース以外の文字を入力して下さい。
                        </div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary mb-3">更新</button>
            </form>
        </div>
    </div>
@endsection
