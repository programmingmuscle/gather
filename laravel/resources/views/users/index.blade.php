@extends ('layouts.mainArea')

@section ('title')
	選手一覧
@endsection

@section ('mainArea_content')
	<form>
		{{ csrf_field() }}
		<div class="container search-box">
			<div class="row">
				<div class="col-9">
					<input type="text" name="keyword" value="{{ $keyword }}" class="form-control" placeholder="キーワードで選手を検索">
				</div>
				<div class="col-3">
					<input type="submit" value="検索" class="btn btn-success">
				</div>
			</div>
		</div>
	</form>

	@if (count($users) > 0)
		<ul class="list-unstyled under-search-box infiniteScroll">

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
								<figure>
									<img src="{{ asset('/assets/images/noimage.jpeg') }}" class="profile_image" alt="ユーザのプロフィール画像です。">
								</figure>
							@endif

						</a>
						<div class="media-body">
							<div class="clearfix">
								<a href="{{ route('users.show', ['id' => $user->id]) }}" class="name-position name-float d-inline-block">{{ $user->name }}</a>
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
		<p class="more text-center pt-2 pb-2 mb-0"><a href="{{ $users->nextPageUrl() }}">もっと見る</a></p>
	@endif

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
	<script src="{{ asset('/assets/js/users-index.js') }}"></script>
@endsection