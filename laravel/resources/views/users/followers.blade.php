@extends ('layouts.mainArea')

@section ('title')
    フォロワー一覧
@endsection

@section ('mainArea_content')
    @if (count($followers) > 0)
        <ul class="list-unstyled">
            @foreach ($followers as $follower)
                <div class="list-border">
                    <li class="media list">
                        <a href="{{ route('users.show', ['id' => $follower->id]) }}"><img class="profile-image" src="{{ Gravatar::src($follower->email), 50}}" alt="ユーザのプロフィール画像です。"></a>
                        <div class="media-body">
                            <div>
                                <a href="{{ route('users.show', ['id' => $follower->id]) }}">{{ $follower->name }}</a>
                                
                                @if (Auth::check() && ($follower->id != Auth::id()))
                                    @include ('user_follow.follow_button')
                                @endif

                                <a href="{{ route('users.show', ['id' => $follower->id]) }}">詳細</a>
                            </div>
                            
                            @include ('commons.userContentList')

                        </div>
                    </li>
                </div>
            @endforeach
        </ul>
    @endif

    {{ $followers->links('pagination::bootstrap-4') }}

@endsection