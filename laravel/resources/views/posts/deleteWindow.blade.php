@extends ('layouts.mainArea')

@section ('title')
    投稿削除
@endsection

@section ('mainArea_content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <form method="POST" action="{{ route('posts.destroy', ['id' => $post->id]) }}">
                    {!! method_field('delete') !!}
                    {{ csrf_field() }}
                    <p>本当に投稿を削除しますか？</p>
                    <div class="form-group">
                        <label for="password">パスワード</label> 
                        @if ($errors->has('password'))
                            <div class="error-target">{{ $errors->first('password') }}</div>
                        @endif
                        <input type="password" name="password" id="password" class="form-control">    
                    </div>
                    <div class="complete-button form-group">
                        <input type="submit" value="削除" class="btn btn-danger">
                    </div>
                </form>
                <div class="explain-link"><a href="{{ route('posts.edit', ['id' => $post->id]) }}">投稿編集</a>に戻る</div>
            </div>
        </div>
    </div>
@endsection