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
                <button class="btn follow-button">フォローする</button>
            @endif

            @include ('commons.contentList')

        </div>
    </div>
    <ul class="nav nav-tabs justify-content-center">
        <li class="nav-item"><a href="#" class="nav-link active">タイムライン</a></li>
        <li class="nav-item"><a href="#" class="nav-link">投稿</a></li>
        <li class="nav-item"><a href="#" class="nav-link">参加</a></li>
        <li class="nav-item"><a href="#" class="nav-link">気になる</a></li>
    </ul>

@endsection