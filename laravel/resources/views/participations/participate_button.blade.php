@if ($post->user->id != Auth::id()) 
    <div class="button-position ml-3">

        @if(Auth::check())
            @if (Auth::user()->is_participating($post->id))
                <form method="POST" action="{{ route('participations.cancel', ['id' => $post->id]) }}" class="d-inline-block">
                    {!! method_field('delete') !!}
                    {{ csrf_field() }}
                    <input type="submit" value="参加中" class="btn cancel-button d-inline-block">
                </form>
            @else
                @include ('participations.common')
            @endif
        @else
            @include ('participations.common')
        @endif
        
    </div>
@endif