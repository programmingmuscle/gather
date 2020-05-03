@extends ('layouts.mainArea')

@section ('title')
    選手一覧
@endsection

@section ('mainArea_content')
    @if (count($users) > 0)
        <ul class="list-unstyled">
            @foreach ($users as $user)
                <div class="list-border">
                    <li class="media players-list">
                        <a href="{{ route('users.show', ['id' => $user->id]) }}"><img class="profile-image" src="{{ Gravatar::src($user->email), 50}}" alt="ユーザのプロフィール画像です。"></a>
                        <div class="media-body">
                            <div>
                                <a href="{{ route('users.show', ['id' => $user->id]) }}">{{ $user->name }}</a>
                                
                                @if (Auth::check() && ($user->id != Auth::id()))
                                    <button class="btn follow-button">フォローする</button>
                                @endif

                            </div>
                            
                            @include ('commons.userContentList')

                        </div>
                    </li>
                </div>
            @endforeach
        </ul>
    @endif

    {{ $users->links('pagination::bootstrap-4') }}

@endsection