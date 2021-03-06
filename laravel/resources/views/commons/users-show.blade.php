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
        
        @yield('tabs')

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
									<div class="name-position name-float d-inline-block">
										<a href="{{ route('users.show', ['id' => $post->user->id]) }}">{{ $post->user->name }}</a>
									</div>

									@if ($post->user->id == Auth::id())
										<div class="button-position button-float">
											<a href="{{ route('posts.edit', ['id' => $post->id]) }}" class="edit-button btn">投稿を編集</a>
										</div>
									@endif
									
								</div>

								@include ('commons.postContentList')

								@include ('participations.participate_button')

								@include ('concerns.concern_button')

							</div>
						</li>
					</div>
				@endforeach

			</ul>

			@if ($posts->hasMorePages())
				<p class="text-center pt-2 pb-2 mb-0"><a href="{{ $posts->nextPageUrl() }}" class="next more">もっと見る</a></p>
			@endif

        @else
        
            @yield ('count-zero')
            
		@endif
		
	</div>
@endsection

@section('js')
	<script src="{{ asset('/assets/js/users-show.js') }}"></script>
@endsection