@if ($post->user->id != Auth::id())
    @if (Auth::check())
        @if (Auth::user()->is_concerned($post->id))
            <form method="POST" action="{{ route('concerns.unconcern', ['id' => $post->id]) }}" class="d-inline-block">
                {!! method_field('delete') !!}
                {{ csrf_field() }}
                <input type="submit" value="気になる" class="btn unconcern-button d-inline-block">
            </form>
        @else
            <form method="POST" action="{{ route('concerns.concern', ['id' => $post->id]) }}" class="d-inline-block">
                {{ csrf_field() }}
                <input type="submit" value="気になる" class="btn concern-button d-inline-block">
            </form>
        @endif
    @else
        <form method="POST" action="{{ route('concerns.concern', ['id' => $post->id]) }}" class="d-inline-block">
            {{ csrf_field() }}
            <input type="submit" value="気になる" class="btn concern-button d-inline-block">
        </form>
    @endif
@endif