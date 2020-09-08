@extends ('layouts.mainArea')

@section ('title')
    <a href="javascript:history.back()" class="back">←</a><div class="d-inline-block">フォロー一覧</div>
@endsection

@section ('mainArea_content')
    @if (count($users) > 0)
        <ul class="list-unstyled">
            @foreach ($users as $user)
                <div class="list-border detail">
                    <a href="{{ route('users.show', ['id' => $user->id]) }}" style="display:none"></a>
                    <li class="media list">
                        <a href="{{ route('users.show', ['id' => $user->id]) }}">
                        @if ($user->profile_image != '')
                            <figure>
                                <img src="/storage/profile_images/{{ $user->id }}.jpg" class="profile_image" alt="ユーザのプロフィール画像です。">
                            </figure>
                        @else
                            <figure id="remove_profile_images">
                                <img src="{{ asset('/assets/images/noimage.jpeg') }}" class="profile_image" alt="ユーザのプロフィール画像です。">
                            </figure>
                        @endif
                        </a>
                        <div class="media-body">
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('users.show', ['id' => $user->id]) }}" class="name-position name-float d-inline-block">{{ $user->name }}</a>
                                <div class="button-position button-float">

                                    @include ('user_follow.follow_button')

                                </div>
                        </div>                        
                            
                            @include ('commons.userContentList')

                        </div>
                    </li>
                </div>
            @endforeach
        </ul>
    @endif

    {{ $users->links('pagination::bootstrap-4') }}

    @section('js')
        <script src="{{ asset('/assets/js/followings.js') }}"></script>
    @endsection

@endsection