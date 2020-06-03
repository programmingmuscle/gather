@extends ('layouts.mainArea')

@section ('title')

    @if ($user->id === Auth::id())
        マイアカウント
    @else
        選手詳細
    @endif

@endsection

@section ('mainArea_content')

    <div class="media show_content">
        <img class="profile-image" src="{{ Gravatar::src($user->email), 50}}" alt="ユーザのプロフィール画像です。">
        <div class="media-body">
            {{ $user->name }}
            
            @if (Auth::check() && ($user->id != Auth::id()))
                @include ('user_follow.follow_button')
            @endif

            @include ('commons.userContentList')

        </div>
    </div>
    <div class="text-center">
        <a href="{{ route('users.followings', ['id' => $user->id]) }}">フォロー中：{{ $count_followings }}</a>
        <a href="{{ route('users.followers', ['id' => $user->id]) }}">フォロワー：{{ $count_followers }}</a>
    </div>
    <ul class="nav nav-tabs justify-content-center">
        <li class="nav-item"><a href="{{ route('users.show', ['id' => $user->id]) }}" class="nav-link active">タイムライン</a></li>
        <li class="nav-item"><a href="{{ route('users.posts', ['id' => $user->id]) }}" class="nav-link">投稿</a></li>
        <li class="nav-item"><a href="{{ route('users.participations', ['id' => $user->id]) }}" class="nav-link">参加</a></li>
        <li class="nav-item"><a href="{{ route('users.concerns', ['id' => $user->id]) }}" class="nav-link">気になる</a></li>
    </ul>

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
                                    
                                    @include ('participations.participate_button')
                                    @include ('concerns.concern_button')

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