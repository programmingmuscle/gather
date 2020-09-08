@extends ('layouts.mainArea')

@section ('title')
    <a href="javascript:history.back()" class="back">←</a><div class="d-inline-block">アカウント削除</div>
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
                        @if ($errors->has('password'))
                            <div class="error-target">{{ $errors->first('password') }}</div>
                        @endif
                        <input type="password" name="password" id="password" class="form-control">    
                    </div>
                    <div class="complete-button form-group">
                        <input type="submit" value="削除" class="btn btn-danger">
                    </div>
                </form>
                <div class="explain-link"><a href="javascript:history.back()">アカウント編集</a>に戻る</div>
            </div>
        </div>
    </div>
@endsection