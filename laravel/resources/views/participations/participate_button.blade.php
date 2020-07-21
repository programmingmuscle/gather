@if ($post->user->id != Auth::id())

    @if(Auth::check())
        @if (Auth::user()->is_participating($post->id))
            <form method="POST" action="{{ route('participations.cancel', ['id' => $post->id]) }}" class="d-inline-block">
                {!! method_field('delete') !!}
                {{ csrf_field() }}
                <input type="submit" value="参加する" class="btn cancel-button d-inline-block">
            </form>
        @else
            <form method="POST" action="{{ route('participations.participate', ['id' => $post->id]) }}" class="d-inline-block">
                {{ csrf_field() }}
                <input type="submit" value="参加する" class="btn participate-button d-inline-block">
            </form>
        @endif
    @else
        <form method="POST" action="{{ route('participations.participate', ['id' => $post->id]) }}" class="d-inline-block">
            {{ csrf_field() }}
            <input type="submit" value="参加する" class="btn participate-button d-inline-block">
        </form>
    @endif
    
@endif