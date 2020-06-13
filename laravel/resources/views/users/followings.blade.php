@extends ('layouts.mainArea')

@section ('title')
    フォロー一覧
@endsection

@section ('mainArea_content')
    @if (count($users) > 0)
        <ul class="list-unstyled">
            @foreach ($users as $user)
                <div class="list-border">
                    <li class="media list">
                        <a href="{{ route('users.show', ['id' => $user->id]) }}">
                        @if ('$is_image')
                            <figure>
                                <img src="/storage/profile_images/{{ $user->id }}.jpg" class="profile_image" alt="ユーザのプロフィール画像です。">
                            </figure>
                        @endif
                        </a>
                        <div class="media-body">
                            <div>
                                <a href="{{ route('users.show', ['id' => $user->id]) }}">{{ $user->name }}</a>
                                
                                
                                    @include ('user_follow.follow_button')
                                

                                
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