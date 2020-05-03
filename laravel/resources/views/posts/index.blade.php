@extends ('layouts.mainArea')

@section ('title')
    投稿一覧
@endsection

@section ('mainArea_content')
    @if (count($posts) > 0)
        <ul class="list-unstyled">
            @foreach ($posts as $post)
                <div class="list-border">
                    <li class="media players-list">
                        <a href="{{ route('users.show', ['id' => $user->id]) }}"><img class="profile-image" src="{{ Gravatar::src($user->email), 50}}" alt="ユーザのプロフィール画像です。"></a>
                        <div class="media-body">
                            <div>
                                <a href="{{ route('users.show', ['id' => $user->id]) }}">{{ $user->name }}</a>
                                
                                @if (Auth::check() && ($user->id != Auth::id()))
                                    <button class="btn follow-button">気になる</button>
                                @endif

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