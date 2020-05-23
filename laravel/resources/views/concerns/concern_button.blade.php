@if (Auth::check() && !($post->user->id == Auth::id()))
    @if (Auth::user()->is_concerned($post->id))
        <form method="POST" action="{{ route('concerns.unconcern', ['id' => $post->id]) }}">
            {!! method_field('delete') !!}
            {{ csrf_field() }}
            <div class="form-group">
                <input type="submit" value="気になる" class="btn concern-button">
            </div>
        </form>
    @else
        <form method="POST" action="{{ route('concerns.concern', ['id' => $post->id]) }}">
            {{ csrf_field() }}
            <div class="form-group">
                <input type="submit" value="気になる" class="btn concern-button">
            </div>
        </form>
    @endif  
@endif