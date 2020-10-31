@if (Auth::check() && ($post->user->id != Auth::id()))
	<div class="button-position ml-3" data-postId="{{ $post->id }}">

		@if (Auth::user()->is_participating($post->id))
			<form method="POST" action="{{ route('participations.cancel', ['id' => $post->id]) }}" class="d-inline-block">
				{!! method_field('delete') !!}
                {{ csrf_field() }}
                <input type="submit" value="参加中" class="btn cancel-button cancel-button-ajax d-inline-block">
			</form>
		@else

			@include ('participations.common')
			
		@endif

	</div>
@endif