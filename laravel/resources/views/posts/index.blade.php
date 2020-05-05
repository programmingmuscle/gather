@extends ('layouts.mainArea')

@section ('title')
    投稿一覧
@endsection

@section ('mainArea_content')
    @if (count($posts) > 0)
        <ul class="list-unstyled">
            @foreach ($posts as $post)
                <div class="list-border">
                    <li class="media list">
                        <a href="{{ route('users.show', ['id' => $post->user->id]) }}"><img class="profile-image" src="{{ Gravatar::src($post->user->email), 50}}" alt="ユーザのプロフィール画像です。"></a>
                        <div class="media-body">
                            <div>
                                <a href="{{ route('users.show', ['id' => $post->user->id]) }}">{{ $post->user->name }}</a>
                                
                                @if (Auth::check() && ($post->user->id != Auth::id()))
                                    <button class="btn concern-button">気になる</button>
                                @endif

                                <a href="{{ route('posts.show', ['id' => $post->id]) }}">詳細</a>

                            </div>
                            
                            @include ('commons.postContentList')

                        </div>
                    </li>
                </div>
            @endforeach
        </ul>
    @endif

    {{ $posts->links('pagination::bootstrap-4') }}

@endsection