@extends ('layouts.mainArea')

@section ('title')
    フォロー一覧
@endsection

@section ('mainArea_content')
    @if (count($followings) > 0)
        <ul class="list-unstyled">
            @foreach ($followings as $following)
                <div class="list-border">
                    <li class="media list">
                        <a href="{{ route('users.show', ['id' => $following->id]) }}"><img class="profile-image" src="{{ Gravatar::src($following->email), 50}}" alt="ユーザのプロフィール画像です。"></a>
                        <div class="media-body">
                            <div>
                                <a href="{{ route('users.show', ['id' => $following->id]) }}">{{ $following->name }}</a>
                                
                                @if (Auth::check() && ($following->id != Auth::id()))
                                    @include ('user_follow.follow_button')
                                @endif

                                <a href="{{ route('users.show', ['id' => $following->id]) }}">詳細</a>
                            </div>
                            
                            @include ('commons.userContentList')

                        </div>
                    </li>
                </div>
            @endforeach
        </ul>
    @endif

    {{ $followings->links('pagination::bootstrap-4') }}

@endsection