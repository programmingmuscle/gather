@extends ('layouts.mainArea')

@section ('title')
	<a href="javascript:history.back()" class="back">←</a><div class="d-inline-block">フォロワー一覧</div>
@endsection

@section ('mainArea_content')

	@if (count($users) > 0)
		<ul class="list-unstyled infiniteScroll">

			@foreach ($users as $user)
				<div class="list-border detail result_infiniteScroll">
					<a href="{{ route('users.show', ['id' => $user->id]) }}" style="display:none"></a>
					<li class="media list">
						<a href="{{ route('users.show', ['id' => $user->id]) }}">

						@if ($user->profile_image != '')
							<figure>
								<img src="{{ $user->profile_image }}" class="profile_image" alt="ユーザのプロフィール画像です。">
							</figure>
						@else
							<figure id="remove_profile_images">
								<img src="{{ asset('/assets/images/noimage.jpeg') }}" class="profile_image" alt="ユーザのプロフィール画像です。">
							</figure>
						@endif

						</a>
						<div class="media-body">
							<div class="clearfix">
								<div class="name-position name-float d-inline-block">
									<a href="{{ route('users.show', ['id' => $user->id]) }}">{{ $user->name }}</a>
								</div>
								<div class="button-position button-float" data-userId="{{ $user->id }}">

									@include ('user_follow.follow_button')

								</div>
							</div>

							@include ('commons.userContentList')

						</div>
					</li>
				</div>
			@endforeach

		</ul>
	@endif

	@if ($users->hasMorePages())
		<p class="text-center pt-2 pb-2 mb-0"><a href="{{ $users->nextPageUrl() }}" class="next more">もっと見る</a></p>
	@endif

@endsection

@section('js')
	<script src="{{ asset('/assets/js/followers.js') }}"></script>
@endsection