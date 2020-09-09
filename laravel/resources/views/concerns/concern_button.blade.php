<div class="button-position ml-3" data-postId="{{ $post->id }}">
    @if (Auth::check())
        @if (Auth::user()->is_concerned($post->id))
            <form class="d-inline-block">
                <input type="submit" value="気になる" class="btn unconcern-button unconcern-button-ajax d-inline-block">
            </form>
        @else
            <form class="d-inline-block">
                <input type="submit" value="気になる" class="btn concern-button concern-button-ajax d-inline-block">
            </form>
        @endif
    @else
        <form class="d-inline-block">                                            
            <input type="submit" value="気になる" class="btn concern-button concern-button-ajax d-inline-block">
        </form>
    @endif
</div>
