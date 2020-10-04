@extends ('layouts.mainArea')

@section ('title')
	ログイン
@endsection

@section ('mainArea_content')
	<div class="container">
		<div class="row">
			<div class="col-md-8 offset-md-2">
				<form method="POST" action="{{ route('login.post') }}">
					{{ csrf_field() }}
					<div class="required-note">
						<span class="required">*</span>が付いている欄は必須項目
					</div>
					<div class="form-group">
						<input type="hidden" name="email" value="guest@gmail.com">
					</div>
					<div class="form-group">
						<input type="hidden" name="password" value="guestguest">
					</div>
					<label for="testLogin" class="testLoginLabel">※ゲストユーザーとして<a class="testLoginLink">ログイン</a>する</label>
					<input type="submit" class="d-none" id="testLogin">
				</form>
				<form method="POST" action="{{ route('login.post') }}" class="login-form">
					{{ csrf_field() }}
					<div class="form-group">
						<label for="email" id="email-error">メールアドレス<span class="required">*</span></label>
						@if ($errors->has('email'))
							<div class="error-target">{{ $errors->first('email') }}</div>
						@endif
						<input type="email" name="email" value="{{ old('email') }}" id="email" class="form-control">
					</div>
					<div class="form-group">
						<label for="password" id="password-error">パスワード<span class="required">*</span></label>
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

	@section('js')
		<script src="{{ asset('/assets/js/login.js') }}"></script>
	@endsection

@endsection