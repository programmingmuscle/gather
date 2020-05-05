@extends ('layouts.mainArea')

@section ('title')

   投稿詳細

@endsection

@section ('mainArea_content')

    <div class="media show_content">
        <img class="profile-image" src="{{ Gravatar::src($post->user->email), 50}}" alt="ユーザのプロフィール画像です。">
        <div class="media-body">
            {{ $post->user->name }}
            
            @if (Auth::check() && ($post->user->id != Auth::id()))
                <button class="btn follow-button">フォローする</button>
            @endif

            @include ('commons.postContentList')

        </div>
    </div>

@endsection