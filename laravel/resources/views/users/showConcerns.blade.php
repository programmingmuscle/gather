@extends ('commons.users-show')

@section ('tabs')

	<li class="timelines"><a href="{{ route('users.show', ['id' => $user->id]) }}">タイムライン</a></li>
	<li class="posts"><a href="{{ route('users.showPosts', ['id' => $user->id]) }}">投稿</a></li>
	<li class="participations"><a href="{{ route('users.showParticipations', ['id' => $user->id]) }}">参加</a></li>
	<li class="concerns active"><a href="{{ route('users.showConcerns', ['id' => $user->id]) }}">気になる</a></li>

@endsection

@section ('count-zero')

	<p class="countZero">"気になる"した投稿がこちらに表示されます。</p>

@endsection