@extends ('layouts.mainArea')

@section ('title')
    ログイン
@endsection

@section ('mainArea_content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <form method="POST" action="{{ route('login.post') }}" class="login-form">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="email" id="email-error">メールアドレス</label> 
                        @if ($errors->has('email'))
                            <div class="error-target">{{ $errors->first('email') }}</div>
                        @endif
                        <input type="email" name="email" value="{{ old('email') }}" id="email" class="form-control">    
                    </div>
                    <div class="form-group">
                        <label for="password" id="password-error">パスワード</label>
                        @if ($errors->has('password'))
                            <div class="error-target">{{ $errors->first('password') }}</div>
                        @endif
                        <input type="password" name="password" id="password" class="form-control">    
                    </div>
                    <div class="complete-button form-group">
                        <input type="submit" value="完了" class="btn btn-success">
                    </div>
                </form>
                <div class="explain-link"><a href="{{ route('signup.get') }}">サインアップ</a>はお済みですか？</div>
            </div>
        </div>
    </div>
@endsection