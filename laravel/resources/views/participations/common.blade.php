<div class="button-position ml-3" data-postId="{{ $post->id }}">

	@if (Auth::user()->is_participating($post->id))
		<form method="POST" action="{{ route('participations.cancel', ['id' => $post->id]) }}" class="d-inline-block">
			{!! method_field('delete') !!}
			{{ csrf_field() }}
			<input type="submit" value="参加中" class="btn cancel-button cancel-button-ajax d-inline-block">
		</form>
	@else

		@if (($post->people > $post->participate_users()->count()) && ($post->deadline > $now))
			<form method="POST" action="{{ route('participations.participate', ['id' => $post->id]) }}" class="d-inline-block">
				{{ csrf_field() }}
				<input type="submit" value="参加する" class="btn participate-button participate-button-ajax d-inline-block">
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