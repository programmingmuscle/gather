@extends ('layouts.mainArea')

@section ('title')
    サインアップ
@endsection

@section ('mainArea_content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <form method="POST" action="{{ route('signup.post') }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="name">選手名</label> 
                        @if ($errors->has('name'))
                            <div class="error-target">{{ $errors->first('name') }}</div>
                        @endif
                        <input type="text" name="name" value="{{ old('name') }}" id="name" class="form-control">    
                    </div>
                    <div class="form-group">
                        <label for="email">メールアドレス</label> 
                        @if ($errors->has('email'))
                            <div class="error-target">{{ $errors->first('email') }}</div>
                        @endif
                        <input type="email" name="email" value="{{ old('email') }}" id="email" class="form-control">    
                    </div>
                    <div class="form-group">
                        <label for="password">パスワード（６文字以上）</label>
                        @if ($errors->has('password'))
                            <div class="error-target">{{ $errors->first('password') }}</div>
                        @endif
                        <input type="password" name="password" id="password" class="form-control">    
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">確認用パスワード</label> 
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">    
                    </div>
                    <div class="complete-button form-group">
                        <input type="submit" value="完了" class="btn btn-success">
                    </div>
                </form>
                <div class="explain-link">サインアップがお済みの方は<a href="{{ route('login') }}">ログイン</a>へ</div>
            </div>
        </div>
    </div>
@endsection