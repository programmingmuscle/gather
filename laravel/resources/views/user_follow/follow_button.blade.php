@if (Auth::check() && ($user->id != Auth::id()))
    @if (Auth::user()->is_following($user->id))
        <form method="POST" action="{{ route('user.unfollow', ['id' => $user->id]) }}">
            {!! method_field('delete') !!}
            {{ csrf_field() }}
            <div class="follow-button form-group">
                <input type="submit" value="フォロー">
            </div>
        </form>
    @else
        <form method="POST" action="{{ route('user.follow', ['id' => $user->id]) }}">
            {{ csrf_field() }}
            <div class="follow-button form-group">
                <input type="submit" value="フォロー">
            </div>
        </form>
    @endif
@endif