@extends ('layouts.app')

@section ('top_body&top_wrapper')
	<div class="top_body">
		<div class="top_wrapper">
@endsection

@section ('content')

	@if (session('success'))
		<div class="alert alert-success flash_message" role="alert">
			{{ session('success') }}
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
	@endif

	<div class="top_content text-center">
		<h1 class="top_app-title">GATHER!</h1>
		<h2 class="top_app-subtitle">~Let's play baseball~</h2>
		<p class="top_sentence">一緒に野球をしてくれる仲間を集めよう！</p>
	</div>
@endsection

@section ('/top_body&/top_wrapper')
		</div>
	</div>
@endsection