@extends ('layouts.mainArea')

@section ('title')

    @if ($user->id === Auth::id())
        マイアカウント
    @else
        <a href="javascript:history.back()" class="back">←</a><div class="d-inline-block">選手詳細</div>
    @endif

@endsection

@section ('mainArea_content')

    <div class="media show_content">

        @if ($user->profile_image != '')
            <figure>
                <img src="/storage/profile_images/{{ $user->id }}.jpg" class="profile_image" alt="ユーザのプロフィール画像です。">
            </figure>
        @else
            <figure>
                <img src="{{ asset('/assets/images/noimage.jpeg') }}" class="profile_image" alt="ユーザのプロフィール画像です。">
            </figure>
        @endif
        
        <div class="media-body">
            <div class="clearfix">
                <div class="name-position name-float d-inline-block">{{ $user->name }}</div>
                <div class="button-position button-float" data-userId="{{ $user->id }}" id="ajax">

                    @include ('user_follow.follow_button')

                </div>
            </div>

            @include ('commons.userContentList')

        </div>
    </div>
    <div class="text-center">

        @if (empty($count_followings))
            <span class="noneFollow ajaxTargetAdd">フォロー中：0</span>
        @else
            <a href="{{ route('users.followings', ['id' => $user->id]) }}" class="ajaxTargetAdd">フォロー中：{{ $count_followings }}</a>
        @endif

        @if (empty($count_followers))
            <span class="noneFollow ajaxTargetRemove">フォロワー：0</span>
        @else
            <a href="{{ route('users.followers', ['id' => $user->id]) }}" class="ajaxTargetRemove">フォロワー：{{ $count_followers }}</a>
        @endif

    </div>
    <ul class="tabs-menu list-unstyled">
        <li class="timelines"><a href="{{ route('users.show', ['id' => $user->id]) }}">タイムライン</a></li>
        <li class="posts active"><a href="{{ route('users.showPosts', ['id' => $user->id]) }}">投稿</a></li>
        <li class="participations"><a href="{{ route('users.showParticipations', ['id' => $user->id]) }}">参加</a></li>
        <li class="concerns"><a href="{{ route('users.showConcerns', ['id' => $user->id]) }}">気になる</a></li>
    </ul>
    <div class="tabs-content">
        @if (count($posts) > 0)
            <ul class="list-unstyled">

                @foreach ($posts as $post)
                    <div class="list-border detail">
                        <a href="{{ route('posts.show', ['id' => $post->id]) }}" style="display:none"></a>
                        <li class="media list">
                            <a href="{{ route('users.show', ['id' => $post->user->id]) }}">

                                @if ($post->user->profile_image != '')
                                    <figure>
                                        <img src="/storage/profile_images/{{ $post->user->id }}.jpg" class="profile_image" alt="ユーザのプロフィール画像です。">
                                    </figure>
                                @else
                                    <figure>
                                        <img src="{{ asset('/assets/images/noimage.jpeg') }}" class="profile_image" alt="ユーザのプロフィール画像です。">
                                    </figure>
                                @endif

                            </a>
                            <div class="media-body">
                                <div class="clearfix">
                                    <a href="{{ route('users.show', ['id' => $post->user->id]) }}" class="name-position name-float d-inline-block">{{ $post->user->name }}</a>
                                    
                                    @if ($post->user->id == Auth::id())
                                        <div class="button-position button-float">
                                            <a href="{{ route('posts.edit', ['id' => $post->id]) }}" class="edit-button btn">投稿を編集</a>
                                        </div>
                                    @endif

                                </div>
                                <ul class="list-unstyled">
                                    <li>
                                        【{{ $post->title }}】
                                    </li>
                                    <div class="ml-3">
                                        <li class="end_time-float">
                                            日時：{{ date('Y/n/j G:i', strtotime($post->date_time)) }}
                                        </li>
                                        <li class="end_time">
                                            {{ '~' . ' ' . date('Y/n/j G:i', strtotime($post->end_time)) }}
                                        </li>
                                        <li class="d-inline-block place">
                                            場所：
                                        </li>
                                        <li class="d-inline-block place-content">
                                            {{ $post->place }}
                                        </li>
                                        <li class="d-inline-block address">
                                            住所：
                                        </li>
                                        <li class="d-inline-block address-content">
                                            {{ $post->address }}
                                        </li>
                                        <li>
                                            場所予約：{{ $post->reservation }}
                                        </li>
                                        <li>
                                            参加費用：{{ $post->expense }}
                                        </li>
                                        <li>
                                            使用球：{{ $post->ball }}
                                        </li>
                                        <li>
                                            応募締切：{{ date('Y/n/j G:i', strtotime($post->deadline)) }}
                                        </li>
                                        <li>
                                            募集人数：{{ $post->participate_users()->count() . '/' . $post->people }}人
                                        </li>
                                    </div>
                                </ul>
                                <p class="ml-3 mt-3">
                                    {!! nl2br(e($post->remarks)) !!}
                                </p>
                                
                                    @include ('participations.participate_button')

                                    @if ($post->user->id != Auth::id())
                                        @include ('concerns.concern_button')
                                    @endif

                            </div>
                        </li>
                    </div>
                @endforeach

            </ul>
            {{ $posts->links('pagination::bootstrap-4') }}
        @else
            <p class="countZero">投稿するとこちらに表示されます。</p>
        @endif
    </div>

    @section('js')
        <script src="{{ asset('/assets/js/users-show.js') }}"></script>
    @endsection

@endsection