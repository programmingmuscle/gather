@if ($post->people > $post->participate_users()->count())
    @if (date('Y/n/j G:i', strtotime($post->deadline)) > $now)
        <form method="POST" action="{{ route('participations.participate', ['id' => $post->id]) }}" class="d-inline-block">
            {{ csrf_field() }}
            <input type="submit" value="参加する" class="btn participate-button d-inline-block">
        </form>
    @else
        <p class="deadline-note">・応募期間終了</p>
        <button class="participate-button-full">参加する</button>
    @endif
@else
    @if (date('Y/n/j G:i', strtotime($post->deadline)) <= $now)
        <p class="full-note">・定員到達</p>
        <p class="deadline-note">・応募期間終了</p>
        <button class="participate-button-full">参加する</button>
    @else
        <p class="full-note">・定員到達</p>
        <button class="participate-button-full">参加する</button>
    @endif
@endif