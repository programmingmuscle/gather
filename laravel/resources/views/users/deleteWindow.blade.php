@extends ('layouts.mainArea')

@section ('title')
    アカウント削除
@endsection

@section ('mainArea_content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <form method="POST" action="{{ route('users.destroy', ['id' => Auth::id()]) }}">
                    {!! method_field('delete') !!}
                    {{ csrf_field() }}
                    <p>本当にアカウントを削除しますか？</p>
                    <div class="form-group">
                        <label for="password">パスワード</label> 
                        <input type="password" name="password" id="password" class="form-control">    
                    </div>
                    <div class="complete-button form-group">
                        <input type="submit" value="削除" class="btn btn-danger">
                    </div>
                </form>
                <div class="explain-link"><a href="{{ route('users.edit', ['id' => Auth::id()]) }}">アカウント編集</a>に戻る</div>
            </div>
        </div>
    </div>
@endsection