@if (Auth::check() && ($user->id != Auth::id()))
    @if (Auth::user()->is_following($user->id))
        <form method="POST" action="{{ route('user.unfollow', ['id' => $user->id]) }}" class="d-inline-block">
            {!! method_field('delete') !!}
            {{ csrf_field() }}
            <input type="submit" value="フォロー" class="btn unfollow-button d-inline-block">
        </form>
    @else
        <form method="POST" action="{{ route('user.follow', ['id' => $user->id]) }}" class="d-inline-block">
            {{ csrf_field() }}
            <input type="submit" value="フォロー" class="btn follow-button d-inline-block">
        </form>
    @endif
@endif