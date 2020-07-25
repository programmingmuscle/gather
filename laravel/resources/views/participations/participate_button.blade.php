@if ($post->user->id != Auth::id())
    @if ($post->people > $post->participate_users()->count())
        <div class="button-position ml-3">

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
            
        </div>
    @else
        @if(Auth::check())
            @if (Auth::user()->is_participating($post->id))
                <div class="button-position ml-3">
                    <form method="POST" action="{{ route('participations.cancel', ['id' => $post->id]) }}" class="d-inline-block">
                        {!! method_field('delete') !!}
                        {{ csrf_field() }}
                        <input type="submit" value="参加する" class="btn cancel-button d-inline-block">
                    </form>
                </div>
            @else
                <p class="full-note">定員到達</p>
                <div class="button-position ml-3">
                    <button class="participate-button-full d-inline-block">参加する</button>
                </div>
            @endif
        @else
            <p class="full-note">定員到達</p>
            <div class="button-position ml-3">
                <button class="participate-button-full d-inline-block">参加する</button>
            </div>
        @endif
    @endif
@endif