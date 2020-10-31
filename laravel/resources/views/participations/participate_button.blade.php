@if (Auth::check() && ($post->user->id != Auth::id()))

	@include ('participations.common')
	
@endif