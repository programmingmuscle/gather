@extends ('layouts.mainArea')

@section ('title')

	@if ($user->id === Auth::id())
		マイアカウント
	@else
		<a href="javascript:history.back()" class="back">←</a><div class="d-inline-block">選手詳細</div>
	@endif

@endsection

@section ('mainArea_content')

	<div class="media show_content">

		@if ($user->profile_image != '')
			<figure>
				<img src="{{ $user->profile_image }}" class="profile_image" alt="ユーザのプロフィール画像です。">
			</figure>
		@else
			<figure>
				<img src="{{ asset('/assets/images/noimage.jpeg') }}" class="profile_image" alt="ユーザのプロフィール画像です。">
			</figure>
		@endif

		<div class="media-body">
			<div class="clearfix">
				<div class="name-position name-float d-inline-block">{{ $user->name }}</div>
				<div class="button-position button-float" data-userId="{{ $user->id }}" id="ajax">

					@include ('user_follow.follow_button')

				</div>
			</div>

			@include ('commons.userContentList')

		</div>
	</div>
	<div class="text-center">

		@if (empty($count_followings))
			<span class="noneFollow ajaxTargetAdd">フォロー中：0</span>
		@else
			<a href="{{ route('users.followings', ['id' => $user->id]) }}" class="ajaxTargetAdd">フォロー中：{{ $count_followings }}</a>
		@endif

		@if (empty($count_followers))
			<span class="noneFollow ajaxTargetRemove">フォロワー：0</span>
		@else
			<a href="{{ route('users.followers', ['id' => $user->id]) }}" class="ajaxTargetRemove">フォロワー：{{ $count_followers }}</a>
		@endif

	</div>
	<ul class="tabs-menu list-unstyled">
		<li class="timelines active"><a href="{{ route('users.show', ['id' => $user->id]) }}">タイムライン</a></li>
		<li class="posts"><a href="{{ route('users.showPosts', ['id' => $user->id]) }}">投稿</a></li>
		<li class="participations"><a href="{{ route('users.showParticipations', ['id' => $user->id]) }}">参加</a></li>
		<li class="concerns"><a href="{{ route('users.showConcerns', ['id' => $user->id]) }}">気になる</a></li>
	</ul>
	<div class="tabs-content">

		@if (count($posts) > 0)
			<ul class="list-unstyled infiniteScroll">

				@foreach ($posts as $post)
					<div class="list-border detail result_infiniteScroll">
						<a href="{{ route('posts.show', ['id' => $post->id]) }}" style="display:none"></a>
						<li class="media list">
							<a href="{{ route('users.show', ['id' => $post->user->id]) }}">

								@if ($post->user->profile_image != '')
									<figure>
										<img src="{{ $post->user->profile_image }}" class="profile_image" alt="ユーザのプロフィール画像です。">
									</figure>
								@else
									<figure>
										<img src="{{ asset('/assets/images/noimage.jpeg') }}" class="profile_image" alt="ユーザのプロフィール画像です。">
									</figure>
								@endif

							</a>
							<div class="media-body">
								<div class="clearfix">
									<a href="{{ route('users.show', ['id' => $post->user->id]) }}" class="name-position name-float d-inline-block">{{ $post->user->name }}</a>

									@if ($post->user->id == Auth::id())
										<div class="button-position button-float">
											<a href="{{ route('posts.edit', ['id' => $post->id]) }}" class="edit-button btn">投稿を編集</a>
										</div>
									@endif

								</div>

								@include ('commons.postContentList')

								@if (Auth::check() && ($post->user->id != Auth::id()))
									<div class="button-position ml-3">
										@if (Auth::user()->is_participating($post->id))
											<form method="POST" action="{{ route('participations.cancel', ['id' => $post->id]) }}" class="d-inline-block">
												{!! method_field('delete') !!}
												{{ csrf_field() }}
												<input type="submit" value="参加中" class="btn cancel-button d-inline-block">
											</form>
										@else
											@if (($post->people > $post->participate_users()->count()) && ($post->deadline > $now))
												<form method="POST" action="{{ route('participations.participate', ['id' => $post->id]) }}" class="d-inline-block">
													{{ csrf_field() }}
													<input type="submit" value="参加する" class="btn participate-button d-inline-block">
												</form>
											@elseif (($post->people <= $post->participate_users()->count()) && ($post->deadline <= $now))
												<p class="full-note">・定員到達</p>
												<p class="deadline-note">・応募期間終了</p>
												<button class="participate-button-full">参加する</button>
											@elseif (($post->people <= $post->participate_users()->count()) && ($post->deadline > $now))
												<p class="full-note">・定員到達</p>
												<button class="participate-button-full">参加する</button>
											@else
												<p class="deadline-note">・応募期間終了</p>
												<button class="participate-button-full">参加する</button>
											@endif
										@endif
									</div>
								@endif

								@if (Auth::check() && ($post->user->id != Auth::id()))
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

			@if ($posts->hasMorePages())
				<p class="more text-center pt-2 pb-2 mb-0"><a href="{{ $posts->nextPageUrl() }}">もっと見る</a></p>
			@endif

		@else
			<p class="countZero">自身とフォロー中ユーザの投稿が表示されます。</p>
		@endif

	</div>
@endsection

@section('js')
	<script src="{{ asset('/assets/js/infinite-scroll.pkgd.min.js') }}"></script>
	<script>
		var infScroll = new InfiniteScroll ('.infiniteScroll', {
			path         : ".more a",
			append       : ".result_infiniteScroll",
			button       : ".more a",
			loadOnScroll : false,
		});
	</script>
	<script src="{{ asset('/assets/js/users-show.js') }}"></script>
@endsection