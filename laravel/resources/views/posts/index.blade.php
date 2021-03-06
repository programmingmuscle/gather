@extends ('layouts.mainArea')

@section ('title')

	@if (Auth::check())
		投稿一覧
	@else
		<div class="d-inline-block">投稿一覧</div><span class="title-note">※ログイン後に"参加"できます。</span>
	@endif

@endsection

@section ('mainArea_content')
	<form>
		{{ csrf_field() }}
		<div class="container search-box">
			<div class="row">
				<div class="col-9">
					<input type="text" name="keyword" value="{{ $keyword }}" class="form-control" placeholder="キーワードで投稿を検索">
				</div>
				<div class="col-3">
					<input type="submit" value="検索" class="btn btn-success">
				</div>
			</div>
		</div>
	</form>

	@if (count($posts) > 0)
		<ul class="list-unstyled under-search-box infiniteScroll">
		
			@foreach ($posts as $post)
				<div class="list-border detail result_infiniteScroll">
					<a href="{{ route('posts.show', ['id' => $post->id]) }}" style="display:none"></a>
					<li class="media list">
						<a href="{{ route('users.show', ['id' => $post->userId]) }}">

							@if ($post->profile_image != '')
								<figure>
									<img src="{{ $post->profile_image }}" class="profile_image" alt="ユーザのプロフィール画像です。">
								</figure>
							@else
								<figure>
									<img src="{{ asset('/assets/images/noimage.jpeg') }}" class="profile_image" alt="ユーザのプロフィール画像です。">
								</figure>
							@endif

						</a>
						<div class="media-body">
							<div class="clearfix">
								<div class="name-position name-float d-inline-block">
									<a href="{{ route('users.show', ['id' => $post->userId]) }}">{{ $post->name }}</a>
								</div>

								@if ($post->userId == Auth::id())
									<div class="button-position button-float">
										<a href="{{ route('posts.edit', ['id' => $post->id]) }}" class="edit-button btn">投稿を編集</a>
									</div>
								@endif
							</div>

							@include ('commons.postContentList')

							@if (Auth::check() && ($post->userId != Auth::id()))

								@include ('participations.common')

							@endif

							@if (Auth::check() && ($post->userId != Auth::id()))
								<div class="button-position ml-3" data-postId="{{ $post->id }}">

									@if (Auth::user()->is_concerned($post->id))
										<form class="d-inline-block">
											<input type="submit" value="気になる" class="btn unconcern-button unconcern-button-ajax d-inline-block">
										</form>
									@else
										<form class="d-inline-block">
											<input type="submit" value="気になる" class="btn concern-button concern-button-ajax d-inline-block">
										</form>
									@endif

								</div>
							@endif

						</div>
					</li>
				</div>
			@endforeach

		</ul>
	@endif

	@if ($posts->hasMorePages())
		<p class="text-center pt-2 pb-2 mb-0"><a href="{{ $posts->nextPageUrl() }}" class="next more">もっと見る</a></p>
	@endif

@endsection

@section('js')
	<script src="{{ asset('/assets/js/posts-index.js') }}"></script>
@endsection