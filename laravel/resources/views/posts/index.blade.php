@extends ('layouts.mainArea')

@section ('title')
    投稿一覧
@endsection

@section ('mainArea_content')
    <form>
        {{ csrf_field() }}       
        <div class="container search-box">
            <div class="row">
                <div class="col-9">
                    <input type="text" name="keyword" value="{{ $keyword }}" class="form-control" placeholder="キーワードで投稿を検索">              
                </div>
                <div class="col-3">
                    <input type="submit" value="検索" class="btn btn-success">
                </div>
            </div>
        </div>
    </form>
    @if (count($posts) > 0)
        <ul class="list-unstyled">
            @foreach ($posts as $post)
                <div class="list-border detail">
                    <a href="{{ route('posts.show', ['id' => $post->id]) }}" style="display:none"></a>
                    <li class="media list">
                        <a href="{{ route('users.show', ['id' => $post->user->id]) }}">
                            @if ($post->user->profile_image != '')
                                <figure>
                                    <img src="/storage/profile_images/{{ $post->user->id }}.jpg" class="profile_image" alt="ユーザのプロフィール画像です。">
                                </figure>
                            @else
                                <figure>
                                    <img src="{{ asset('/assets/images/noimage.jpeg') }}" class="profile_image" alt="ユーザのプロフィール画像です。">
                                </figure>
                            @endif
                        </a>
                        <div class="media-body">
                            <div class="clearfix">              
                                <a href="{{ route('users.show', ['id' => $post->user->id]) }}" class="name-position name-float d-inline-block">{{ $post->user->name }}</a>

                                @if ($post->user->id == Auth::id())
                                    <div class="button-position button-float">
                                        <a href="{{ route('posts.edit', ['id' => $post->id]) }}" class="edit-button btn">投稿を編集</a>
                                    </div>
                                @endif               
                            </div>

                            @include ('commons.postContentList')
                            
                            @if (Auth::check() && !($post->user->id == Auth::id()))
                                <div class="button-position ml-3">
                                    @include ('participations.participate_button')
                                    @include ('concerns.concern_button')
                                </div>
                            @endif

                        </div>
                    </li>
                </div>
            @endforeach
        </ul>
    @endif

    {{ $posts->links('pagination::bootstrap-4') }}

@endsection