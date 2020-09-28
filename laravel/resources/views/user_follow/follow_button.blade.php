@if (Auth::check() && ($user->id != Auth::id()))
	@if (Auth::user()->is_following($user->id))
		<form class="d-inline-block">
			<input type="submit" value="フォロー中" class="btn unfollow-button unfollow-button-ajax d-inline-block">
		</form>
	@else
		<form class="d-inline-block">
			<input type="submit" value="フォロー" class="btn follow-button follow-button-ajax d-inline-block">
		</form>
	@endif
@endif