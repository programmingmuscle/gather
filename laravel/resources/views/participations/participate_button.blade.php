@if (Auth::check() && !($post->user->id == Auth::id()))
    @if (Auth::user()->is_participating($post->id))
        <form method="POST" action="{{ route('participations.cancel', ['id' => $post->id]) }}">
            {!! method_field('delete') !!}
            {{ csrf_field() }}
            <div class="form-group">
                <input type="submit" value="参加する" class="btn participate-button">
            </div>
        </form>
    @else
        <form method="POST" action="{{ route('participations.participate', ['id' => $post->id]) }}">
            {{ csrf_field() }}
            <div class="form-group">
                <input type="submit" value="参加する" class="btn participate-button">
            </div>
        </form>
    @endif  
@endif