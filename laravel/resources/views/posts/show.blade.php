@extends ('layouts.mainArea')

@section ('title')
   投稿詳細
@endsection

@section ('mainArea_content')
    <div class="media show_content">
        <img class="profile-image" src="{{ Gravatar::src($post->user->email), 50}}" alt="ユーザのプロフィール画像です。">
        <div class="media-body">
            {{ $post->user->name }}
            
            @if (Auth::check() && !($post->user->id == Auth::id()))
               
                @include ('participations.participate_button')
                @include ('concerns.concern_button')

            @endif

            @if ($post->user->id == Auth::id())
                <a href="{{ route('posts.edit', ['id' => $post->id]) }}">編集</a>
            @endif

            @include ('commons.postContentList')

        </div>
    </div>
@endsection