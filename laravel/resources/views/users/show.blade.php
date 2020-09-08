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
    <div class="text-center ">

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
        <li class="timelines"><a href="#tabs-timelines">タイムライン</a></li>
        <li class="posts"><a href="#tabs-posts">投稿</a></li>
        <li class="participations"><a href="#tabs-participations">参加</a></li>
        <li class="concerns"><a href="#tabs-concerns">気になる</a></li>
    </ul>
    <section class="tabs-content">
        <section id="tabs-timelines">
            @if (count($timelines) > 0)
                <ul class="list-unstyled">
                    @foreach ($timelines as $timeline)
                        <div class="list-border detail">
                            <a href="{{ route('posts.show', ['id' => $timeline->id]) }}" style="display:none"></a>
                            <li class="media list">
                                <a href="{{ route('users.show', ['id' => $timeline->user->id]) }}">
                                    @if ($timeline->user->profile_image != '')
                                        <figure>
                                            <img src="/storage/profile_images/{{ $timeline->user->id }}.jpg" class="profile_image" alt="ユーザのプロフィール画像です。">
                                        </figure>
                                    @else
                                        <figure>
                                            <img src="{{ asset('/assets/images/noimage.jpeg') }}" class="profile_image" alt="ユーザのプロフィール画像です。">
                                        </figure>
                                    @endif
                                </a>
                                <div class="media-body">
                                    <div class="clearfix">
                                        <a href="{{ route('users.show', ['id' => $timeline->user->id]) }}" class="name-position name-float d-inline-block">{{ $timeline->user->name }}</a>

                                        @if ($timeline->user->id == Auth::id())
                                            <div class="button-position button-float">
                                                <a href="{{ route('posts.edit', ['id' => $timeline->id]) }}" class="edit-button btn">投稿を編集</a>
                                            </div>
                                        @endif 
                                    </div>
                                    <ul class="list-unstyled">
                                        <li>
                                            【{{ $timeline->title }}】
                                        </li>      
                                        <div class="ml-3">
                                            <li class="end_time-float">
                                                日時：{{ date('Y/n/j G:i', strtotime($timeline->date_time)) }}
                                            </li>
                                            <li class="end_time">
                                                {{ '~' . ' ' . date('Y/n/j G:i', strtotime($timeline->end_time)) }}
                                            </li>
                                            <li class="d-inline-block place">
                                                場所：
                                            </li>
                                            <li class="d-inline-block place-content">
                                                {{ $timeline->place }}
                                            </li>
                                            <li class="d-inline-block address">
                                                住所：
                                            </li>
                                            <li class="d-inline-block address-content">
                                                {{ $timeline->address }}
                                            </li>
                                            <li>
                                                場所予約：{{ $timeline->reservation }}
                                            </li>
                                            <li>
                                                参加費用：{{ $timeline->expense }}
                                            </li>
                                            <li>
                                                使用球：{{ $timeline->ball }}
                                            </li>
                                            <li>
                                                応募締切：{{ date('Y/n/j G:i', strtotime($timeline->deadline)) }}
                                            </li>
                                            <li>
                                                募集人数：{{ $timeline->participate_users()->count() . '/' . $timeline->people }}人
                                            </li>
                                        </div>
                                    </ul>
                                    <p class="ml-3 mt-3">
                                        {!! nl2br(e($timeline->remarks)) !!}
                                    </p>

                                    @if ($timeline->user->id != Auth::id()) 
                                        <div class="button-position ml-3">

                                            @if(Auth::check())
                                                @if (Auth::user()->is_participating($timeline->id))
                                                    <form method="POST" action="{{ route('participations.cancel', ['id' => $timeline->id]) }}" class="d-inline-block">
                                                        {!! method_field('delete') !!}
                                                        {{ csrf_field() }}
                                                        <input type="submit" value="参加する" class="btn cancel-button d-inline-block">
                                                    </form>
                                                @else
                                                    @if (($timeline->people > $timeline->participate_users()->count()) && ($timeline->deadline > $now))
                                                        <form method="POST" action="{{ route('participations.participate', ['id' => $timeline->id]) }}" class="d-inline-block">
                                                            {{ csrf_field() }}
                                                            <input type="submit" value="参加する" class="btn participate-button d-inline-block">
                                                        </form>
                                                    @elseif (($timeline->people <= $timeline->participate_users()->count()) && ($timeline->deadline <= $now))
                                                        <p class="full-note">・定員到達</p>
                                                        <p class="deadline-note">・応募期間終了</p>
                                                        <button class="participate-button-full">参加する</button>
                                                    @elseif (($timeline->people <= $timeline->participate_users()->count()) && ($timeline->deadline > $now))
                                                        <p class="full-note">・定員到達</p>
                                                        <button class="participate-button-full">参加する</button>
                                                    @else
                                                        <p class="deadline-note">・応募期間終了</p>
                                                        <button class="participate-button-full">参加する</button>
                                                    @endif
                                                @endif
                                            @else
                                                @if (($timeline->people > $timeline->participate_users()->count()) && ($timeline->deadline > $now))
                                                    <form method="POST" action="{{ route('participations.participate', ['id' => $timeline->id]) }}" class="d-inline-block">
                                                        {{ csrf_field() }}
                                                        <input type="submit" value="参加する" class="btn participate-button d-inline-block">
                                                    </form>
                                                @elseif (($timeline->people <= $timeline->participate_users()->count()) && ($timeline->deadline <= $now))
                                                    <p class="full-note">・定員到達</p>
                                                    <p class="deadline-note">・応募期間終了</p>
                                                    <button class="participate-button-full">参加する</button>
                                                @elseif (($timeline->people <= $timeline->participate_users()->count()) && ($timeline->deadline > $now))
                                                    <p class="full-note">・定員到達</p>
                                                    <button class="participate-button-full">参加する</button>
                                                @else
                                                    <p class="deadline-note">・応募期間終了</p>
                                                    <button class="participate-button-full">参加する</button>
                                                @endif
                                            @endif
                                            
                                        </div>
                                    @endif
                                    @if ($timeline->user->id != Auth::id())
                                        <div class="button-position ml-3">
                                            @if (Auth::check())
                                                @if (Auth::user()->is_concerned($timeline->id))
                                                    <form method="POST" action="{{ route('concerns.unconcern', ['id' => $timeline->id]) }}" class="d-inline-block">
                                                        {!! method_field('delete') !!}
                                                        {{ csrf_field() }}
                                                        <input type="submit" value="気になる" class="btn unconcern-button d-inline-block">
                                                    </form>
                                                @else
                                                    <form method="POST" action="{{ route('concerns.concern', ['id' => $timeline->id]) }}" class="d-inline-block">
                                                        {{ csrf_field() }}
                                                        <input type="submit" value="気になる" class="btn concern-button d-inline-block">
                                                    </form>
                                                @endif
                                            @else
                                                <form method="POST" action="{{ route('concerns.concern', ['id' => $timeline->id]) }}" class="d-inline-block">
                                                    {{ csrf_field() }}
                                                    <input type="submit" value="気になる" class="btn concern-button d-inline-block">
                                                </form>
                                            @endif
                                        </div>
                                    @endif
                                    
                                </div>
                            </li>
                        </div>                               
                    @endforeach
                </ul>
                {{ $timelines->links('pagination::bootstrap-4') }}
            @else
                <p class="countZero">自身とフォロー中ユーザの投稿が表示されます。</p>
            @endif
        </section>
        <section id="tabs-posts">

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

                                        @include ('concerns.concern_button')

                                </div>
                            </li>
                        </div>
                    @endforeach

                </ul>
                {{ $posts->links('pagination::bootstrap-4') }}
            @else
                <p class="countZero">投稿するとこちらに表示されます。</p>
            @endif

        </section>
        <section id="tabs-participations">

            @if (count($participations) > 0)
                <ul class="list-unstyled">

                    @foreach ($participations as $participation)
                        <div class="list-border detail">
                            <a href="{{ route('posts.show', ['id' => $participation->id]) }}" style="display:none"></a>
                            <li class="media list">
                                <a href="{{ route('users.show', ['id' => $participation->user->id]) }}">

                                    @if ($participation->user->profile_image != '')
                                        <figure>
                                            <img src="/storage/profile_images/{{ $participation->user->id }}.jpg" class="profile_image" alt="ユーザのプロフィール画像です。">
                                        </figure>
                                    @else
                                        <figure>
                                            <img src="{{ asset('/assets/images/noimage.jpeg') }}" class="profile_image" alt="ユーザのプロフィール画像です。">
                                        </figure>
                                    @endif

                                </a>
                                <div class="media-body">
                                    <a href="{{ route('users.show', ['id' => $participation->user->id]) }}" class="name-position d-inline-block">{{ $participation->user->name }}</a>
                                    <ul class="list-unstyled">
                                        <li>
                                            【{{ $participation->title }}】
                                        </li>
                                        <div class="ml-3">
                                            <li class="end_time-float">
                                                日時：{{ date('Y/n/j G:i', strtotime($participation->date_time)) }}
                                            </li>
                                            <li class="end_time">
                                                {{ '~' . ' ' . date('Y/n/j G:i', strtotime($participation->end_time)) }}
                                            </li>
                                            <li class="d-inline-block place">
                                                場所：
                                            </li>
                                            <li class="d-inline-block place-content">
                                                {{ $participation->place }}
                                            </li>
                                            <li class="d-inline-block address">
                                                住所：
                                            </li>
                                            <li class="d-inline-block address-content">
                                                {{ $participation->address }}
                                            </li>
                                            <li>
                                                場所予約：{{ $participation->reservation }}
                                            </li>
                                            <li>
                                                参加費用：{{ $participation->expense }}
                                            </li>
                                            <li>
                                                使用球：{{ $participation->ball }}
                                            </li>
                                            <li>
                                                応募締切：{{ date('Y/n/j G:i', strtotime($participation->deadline)) }}
                                            </li>
                                            <li>
                                                募集人数：{{ $participation->participate_users()->count() . '/' . $participation->people }}人
                                            </li>
                                        </div>
                                    </ul>
                                    <p class="ml-3 mt-3">
                                        {!! nl2br(e($participation->remarks)) !!}
                                    </p>

                                    @if ($participation->user->id != Auth::id()) 
                                        <div class="button-position ml-3">

                                            @if(Auth::check())
                                                @if (Auth::user()->is_participating($participation->id))
                                                    <form method="POST" action="{{ route('participations.cancel', ['id' => $participation->id]) }}" class="d-inline-block">
                                                        {!! method_field('delete') !!}
                                                        {{ csrf_field() }}
                                                        <input type="submit" value="参加する" class="btn cancel-button d-inline-block">
                                                    </form>
                                                @else
                                                    @if (($participation->people > $participation->participate_users()->count()) && ($participation->deadline > $now))
                                                        <form method="POST" action="{{ route('participations.participate', ['id' => $participation->id]) }}" class="d-inline-block">
                                                            {{ csrf_field() }}
                                                            <input type="submit" value="参加する" class="btn participate-button d-inline-block">
                                                        </form>
                                                    @elseif (($participation->people <= $participation->participate_users()->count()) && ($participation->deadline <= $now))
                                                        <p class="full-note">・定員到達</p>
                                                        <p class="deadline-note">・応募期間終了</p>
                                                        <button class="participate-button-full">参加する</button>
                                                    @elseif (($participation->people <= $participation->participate_users()->count()) && ($participation->deadline > $now))
                                                        <p class="full-note">・定員到達</p>
                                                        <button class="participate-button-full">参加する</button>
                                                    @else
                                                        <p class="deadline-note">・応募期間終了</p>
                                                        <button class="participate-button-full">参加する</button>
                                                    @endif
                                                @endif
                                            @else
                                                @if (($participation->people > $participation->participate_users()->count()) && ($participation->deadline > $now))
                                                    <form method="POST" action="{{ route('participations.participate', ['id' => $participation->id]) }}" class="d-inline-block">
                                                        {{ csrf_field() }}
                                                        <input type="submit" value="参加する" class="btn participate-button d-inline-block">
                                                    </form>
                                                @elseif (($participation->people <= $participation->participate_users()->count()) && ($participation->deadline <= $now))
                                                    <p class="full-note">・定員到達</p>
                                                    <p class="deadline-note">・応募期間終了</p>
                                                    <button class="participate-button-full">参加する</button>
                                                @elseif (($participation->people <= $participation->participate_users()->count()) && ($participation->deadline > $now))
                                                    <p class="full-note">・定員到達</p>
                                                    <button class="participate-button-full">参加する</button>
                                                @else
                                                    <p class="deadline-note">・応募期間終了</p>
                                                    <button class="participate-button-full">参加する</button>
                                                @endif
                                            @endif
                                            
                                        </div>
                                    @endif
                                    @if ($participation->user->id != Auth::id())
                                        <div class="button-position ml-3">
                                            @if (Auth::check())
                                                @if (Auth::user()->is_concerned($participation->id))
                                                    <form method="POST" action="{{ route('concerns.unconcern', ['id' => $participation->id]) }}" class="d-inline-block">
                                                        {!! method_field('delete') !!}
                                                        {{ csrf_field() }}
                                                        <input type="submit" value="気になる" class="btn unconcern-button d-inline-block">
                                                    </form>
                                                @else
                                                    <form method="POST" action="{{ route('concerns.concern', ['id' => $participation->id]) }}" class="d-inline-block">
                                                        {{ csrf_field() }}
                                                        <input type="submit" value="気になる" class="btn concern-button d-inline-block">
                                                    </form>
                                                @endif
                                            @else
                                                <form method="POST" action="{{ route('concerns.concern', ['id' => $participation->id]) }}" class="d-inline-block">
                                                    {{ csrf_field() }}
                                                    <input type="submit" value="気になる" class="btn concern-button d-inline-block">
                                                </form>
                                            @endif
                                        </div>
                                    @endif

                                </div>
                            </li>
                        </div>
                    @endforeach

                </ul>
                {{ $participations->links('pagination::bootstrap-4') }}
            @else
                <p class="countZero">"参加"した投稿がこちらに表示されます。</p>
            @endif

        </section>
        <section id="tabs-concerns">

            @if (count($concerns) > 0)
                <ul class="list-unstyled">

                    @foreach ($concerns as $concern)
                        <div class="list-border detail">
                            <a href="{{ route('posts.show', ['id' => $concern->id]) }}" style="display:none"></a>
                            <li class="media list">
                                <a href="{{ route('users.show', ['id' => $concern->user->id]) }}">
                                
                                    @if ($concern->user->profile_image != '')
                                        <figure>
                                            <img src="/storage/profile_images/{{ $concern->user->id }}.jpg" class="profile_image" alt="ユーザのプロフィール画像です。">
                                        </figure>
                                    @else
                                        <figure>
                                            <img src="{{ asset('/assets/images/noimage.jpeg') }}" class="profile_image" alt="ユーザのプロフィール画像です。">
                                        </figure>
                                    @endif

                                </a>
                                <div class="media-body">
                                    <a href="{{ route('users.show', ['id' => $concern->user->id]) }}" class="name-position d-inline-block">{{ $concern->user->name }}</a>
                                    <ul class="list-unstyled">
                                        <li>
                                            【{{ $concern->title }}】
                                        </li>
                                        <div class="ml-3">
                                            <li class="end_time-float">
                                                日時：{{ date('Y/n/j G:i', strtotime($concern->date_time)) }}
                                            </li>
                                            <li class="end_time">
                                                {{ '~' . ' ' . date('Y/n/j G:i', strtotime($concern->end_time)) }}
                                            </li>
                                            <li class="d-inline-block place">
                                                場所：
                                            </li>
                                            <li class="d-inline-block place-content">
                                                {{ $concern->place }}
                                            </li>
                                            <li class="d-inline-block address">
                                                住所：
                                            </li>
                                            <li class="d-inline-block address-content">
                                                {{ $concern->address }}
                                            </li>
                                            <li>
                                                場所予約：{{ $concern->reservation }}
                                            </li>
                                            <li>
                                                参加費用：{{ $concern->expense }}
                                            </li>
                                            <li>
                                                使用球：{{ $concern->ball }}
                                            </li>
                                            <li>
                                                応募締切：{{ date('Y/n/j G:i', strtotime($concern->deadline)) }}
                                            </li>
                                            <li>
                                                募集人数：{{ $concern->participate_users()->count() . '/' . $concern->people }}人
                                            </li>
                                        </div>
                                    </ul>
                                    <p class="ml-3 mt-3">
                                        {!! nl2br(e($concern->remarks)) !!}
                                    </p>
                                    
                                    @if ($concern->user->id != Auth::id()) 
                                        <div class="button-position ml-3">

                                            @if(Auth::check())
                                                @if (Auth::user()->is_participating($concern->id))
                                                    <form method="POST" action="{{ route('participations.cancel', ['id' => $concern->id]) }}" class="d-inline-block">
                                                        {!! method_field('delete') !!}
                                                        {{ csrf_field() }}
                                                        <input type="submit" value="参加する" class="btn cancel-button d-inline-block">
                                                    </form>
                                                @else
                                                    @if (($concern->people > $concern->participate_users()->count()) && ($concern->deadline > $now))
                                                        <form method="POST" action="{{ route('participations.participate', ['id' => $concern->id]) }}" class="d-inline-block">
                                                            {{ csrf_field() }}
                                                            <input type="submit" value="参加する" class="btn participate-button d-inline-block">
                                                        </form>
                                                    @elseif (($concern->people <= $concern->participate_users()->count()) && ($concern->deadline <= $now))
                                                        <p class="full-note">・定員到達</p>
                                                        <p class="deadline-note">・応募期間終了</p>
                                                        <button class="participate-button-full">参加する</button>
                                                    @elseif (($concern->people <= $concern->participate_users()->count()) && ($concern->deadline > $now))
                                                        <p class="full-note">・定員到達</p>
                                                        <button class="participate-button-full">参加する</button>
                                                    @else
                                                        <p class="deadline-note">・応募期間終了</p>
                                                        <button class="participate-button-full">参加する</button>
                                                    @endif
                                                @endif
                                            @else
                                                @if (($concern->people > $concern->participate_users()->count()) && ($concern->deadline > $now))
                                                    <form method="POST" action="{{ route('participations.participate', ['id' => $concern->id]) }}" class="d-inline-block">
                                                        {{ csrf_field() }}
                                                        <input type="submit" value="参加する" class="btn participate-button d-inline-block">
                                                    </form>
                                                @elseif (($concern->people <= $concern->participate_users()->count()) && ($concern->deadline <= $now))
                                                    <p class="full-note">・定員到達</p>
                                                    <p class="deadline-note">・応募期間終了</p>
                                                    <button class="participate-button-full">参加する</button>
                                                @elseif (($concern->people <= $concern->participate_users()->count()) && ($concern->deadline > $now))
                                                    <p class="full-note">・定員到達</p>
                                                    <button class="participate-button-full">参加する</button>
                                                @else
                                                    <p class="deadline-note">・応募期間終了</p>
                                                    <button class="participate-button-full">参加する</button>
                                                @endif
                                            @endif
                                        
                                        </div>
                                    @endif
                                    @if ($concern->user->id != Auth::id())
                                        <div class="button-position ml-3">
                                            @if (Auth::check())
                                                @if (Auth::user()->is_concerned($concern->id))
                                                    <form method="POST" action="{{ route('concerns.unconcern', ['id' => $concern->id]) }}" class="d-inline-block">
                                                        {!! method_field('delete') !!}
                                                        {{ csrf_field() }}
                                                        <input type="submit" value="気になる" class="btn unconcern-button d-inline-block">
                                                    </form>
                                                @else
                                                    <form method="POST" action="{{ route('concerns.concern', ['id' => $concern->id]) }}" class="d-inline-block">
                                                        {{ csrf_field() }}
                                                        <input type="submit" value="気になる" class="btn concern-button d-inline-block">
                                                    </form>
                                                @endif
                                            @else
                                                <form method="POST" action="{{ route('concerns.concern', ['id' => $concern->id]) }}" class="d-inline-block">
                                                    {{ csrf_field() }}
                                                    <input type="submit" value="気になる" class="btn concern-button d-inline-block">
                                                </form>
                                            @endif
                                        </div>
                                    @endif

                                </div>
                            </li>
                        </div>
                    @endforeach

                </ul>
                {{ $concerns->links('pagination::bootstrap-4') }}
            @else
                <p class="countZero">"気になる"した投稿がこちらに表示されます。</p>
            @endif 

        </section>
    </section>

    @section('js')
        <script src="{{ asset('/assets/js/users-show.js') }}"></script>
    @endsection

@endsection