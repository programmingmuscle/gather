<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="utf-8">
		<title>GATHER! ~Let's play baseball~</title>
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
		<link href="https://fonts.googleapis.com/css?family=Lato:400,700|Noto+Sans+JP:400,700" rel="stylesheet">
		<link rel="stylesheet" href="{{ asset('/assets/css/main.css') }}">
	</head>
	<body>

		@yield ('top_body&top_wrapper')

				<div class="wrapper">
					<header class="bg-success">
						<nav class="navbar navbar-expand-sm navbar-dark">
							
							@if (Auth::check())
								<a href="{{ route('users.show', ['id' => Auth::id()]) }}" class="navbar-brand">GATHER!</a>
							@else
								<a href="/" class="navbar-brand">GATHER!</a>
							@endif

							<button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#nav-bar">
								<span class="navbar-toggler-icon"></span>
							</button>
							<div class="collapse navbar-collapse" id="nav-bar">
								<ul class="navbar-nav ml-auto">
									@if (Auth::check())
										<li class="nav-item"><a href="{{ route('posts.index') }}" class="nav-link">投稿一覧</a></li>
										<li class="nav-item"><a href="{{ route('users.index') }}" class="nav-link">選手一覧</a></li>									
										<li class="nav-item dropdown">
											<a href="#" class="nav-link nav-link-account dropdown-toggle" data-toggle="dropdown">マイアカウント</a>
											<ul class="dropdown-menu dropdown-menu-right">
												<li class="dropdown-item"><a href="{{ route('users.show', ['id' => Auth::id()]) }}">マイアカウント</a></li>
												<li class="dropdown-item"><a href="{{ route('users.edit', ['id' => Auth::id()]) }}">アカウント編集</a></li>
												<li class="dropdown-divider"></li>
												<li class="dropdown-item"><a href="{{ route('logout.get') }}">ログアウト</a></li>
											</ul>
										</li>
									@else
										<li class="nav-item"><a href="{{ route('posts.index') }}" class="nav-link">投稿一覧</a></li>
										<li class="nav-item"><a href="{{ route('users.index') }}" class="nav-link">選手一覧</a></li>										
										<li class="nav-item"><a href="{{ route('signup.get') }}" class="nav-link">サインアップ</a></li>
										<li class="nav-item"><a href="{{ route('login') }}" class="nav-link nav-link-login">ログイン</a></li>
									@endif
								</ul>
							</div>
						</nav>
					</header>
					<div class="main">
												
						@yield ('content')

					</div>
					<footer class="text-center text-light bg-success">
						<small>&copy; 2020 GATHER!</small>
					</footer>
				</div>

		@yield ('/top_body&/top_wrapper')	

		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
		<script defer src="https://use.fontawesome.com/releases/v5.7.2/js/all.js"></script>
	</body>
</html>