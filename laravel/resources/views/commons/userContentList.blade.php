<ul class="list-unstyled">

	@if (!(isset($user->residence)) && !(isset($user->gender)) && !(isset($user->age)) && !(isset($user->experience)) && !(isset($user->position)) && !(isset($user->introduction)))
		<p class="profile-color">プロフィール未登録 @if ($user->id == Auth::id())(<a href="{{ route('users.edit', ['id' => $user->id]) }}">アカウント編集</a>にて設定できます) @endif</p>
	@endif

	@if (isset($user->residence))
		<li class="d-inline-block residence">
			居住地：
		</li>
		<li class="d-inline-block residence-content">
			{{ $user->residence }}
		</li>
	@endif

	@if (isset($user->gender))
		<li>
			性別：{{ $user->gender }}
		</li>
	@endif

	@if (isset($user->age))
		<li>
			年齢：{{ $user->age }}
		</li>
	@endif

	@if (isset($user->experience))
		<li>
			野球歴：{{ $user->experience }}
		</li>
	@endif

	@if (isset($user->position))
		<li>
			ポジション：{{ $user->position }}
		</li>
	@endif

</ul>
<p class="mt-3">
	{!! nl2br(e($user->introduction)) !!}
</p>