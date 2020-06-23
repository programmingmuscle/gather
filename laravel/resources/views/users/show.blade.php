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
        @if ($user->profile_image != '')
            <figure>
                <img src="/storage/profile_images/{{ $user->id }}.jpg" class="profile_image" alt="ユーザのプロフィール画像です。">
            </figure>
        @else
            <figure id="remove_profile_images">
                <img src="{{ asset('/assets/images/noimage.jpeg') }}" class="profile_image" alt="ユーザのプロフィール画像です。">
            </figure>
        @endif
        <div class="media-body">
            {{ $user->name }}
            
            @if (Auth::check() && ($user->id != Auth::id()))
                @include ('user_follow.follow_button')
            @endif

            @include ('commons.userContentList')

        </div>
    </div>
    <div class="text-center">
        <a href="{{ route('users.followings', ['id' => $user->id]) }}">フォロー中：{{ $count_followings }}</a>
        <a href="{{ route('users.followers', ['id' => $user->id]) }}">フォロワー：{{ $count_followers }}</a>
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
                                    @endif
                                </a>
                                <div class="media-body">
                                    <div>
                                        <a href="{{ route('users.show', ['id' => $timeline->user->id]) }}">{{ $timeline->user->name }}</a>
                                    </div>
                                    <ul class="list-unstyled">
                                        <li>
                                            【{{ $timeline->title }}】
                                        </li>                                        
                                        <li>
                                            日時：{{ substr($timeline->date_time, 0, 16) . '~' . substr($timeline->end_time, 0, 5) }}
                                        </li>
                                        <li>
                                            場所：{{ $timeline->place }}
                                        </li>
                                        <li>
                                            住所：{{ $timeline->address }}
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
                                            応募締切：{{ substr($timeline->deadline, 0, 16) }}
                                        </li>
                                        <li>
                                            募集人数：{{ $timeline->people }}
                                        </li>
                                    </ul>
                                    <p>
                                        {{ $timeline->remarks }}
                                    </p>
                                    @if (Auth::check() && ($timeline->user->id != Auth::id()))     
                                        
                                        @if (Auth::user()->is_participating($timeline->id))
                                            <form method="POST" action="{{ route('participations.cancel', ['id' => $timeline->id]) }}">
                                                {!! method_field('delete') !!}
                                                {{ csrf_field() }}
                                                <input type="submit" value="参加する" class="btn participate-button">
                                            </form>
                                        @else
                                            <form method="POST" action="{{ route('participations.participate', ['id' => $timeline->id]) }}">
                                                {{ csrf_field() }}
                                                <input type="submit" value="参加する" class="btn participate-button">
                                            </form>
                                        @endif  
                                    
                                        @if (Auth::user()->is_concerned($timeline->id))
                                            <form method="POST" action="{{ route('concerns.unconcern', ['id' => $timeline->id]) }}">
                                                {!! method_field('delete') !!}
                                                {{ csrf_field() }}
                                                <input type="submit" value="気になる" class="btn concern-button">
                                            </form>
                                        @else
                                            <form method="POST" action="{{ route('concerns.concern', ['id' => $timeline->id]) }}">
                                                {{ csrf_field() }}
                                                <input type="submit" value="気になる" class="btn concern-button">
                                            </form>
                                        @endif

                                    @endif
                                    
                                </div>
                            </li>
                        </div>                               
                    @endforeach
                </ul>
                {{ $timelines->links('pagination::bootstrap-4') }}
            @endif
        </section>
        <section id="tabs-posts">
            @if (count($posts) > 0)
                <ul class="list-unstyled">
                    @foreach ($posts as $post)
                        <div class="list-border detail">
                            <a href="{{ route('posts.show', ['id' => $post->id]) }}" style="display:none"></a>
                            <li class="media list">
                                
                                @if ($post->user->profile_image != '')
                                    <figure>
                                        <img src="/storage/profile_images/{{ $post->user->id }}.jpg" class="profile_image" alt="ユーザのプロフィール画像です。">
                                    </figure>
                                @else
                                    <figure id="remove_profile_images">
                                        <img src="{{ asset('/assets/images/noimage.jpeg') }}" class="profile_image" alt="ユーザのプロフィール画像です。">
                                    </figure>
                                @endif
                                
                                <div class="media-body">
                                    <div>
                                        {{ $user->name }}
                                    </div>
                                    
                                    <ul class="list-unstyled">
                                        <li>
                                            【{{ $post->title }}】
                                        </li>
                                        <li>
                                            日時：{{ substr($post->date_time, 0, 16) . '~' . substr($post->end_time, 0, 5) }}
                                        </li>
                                        <li>
                                            場所：{{ $post->place }}
                                        </li>
                                        <li>
                                            住所：{{ $post->address }}
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
                                            応募締切：{{ substr($post->deadline, 0, 16) }}
                                        </li>
                                        <li>
                                            募集人数：{{ $post->people }}
                                        </li>
                                    </ul>
                                    <p>
                                        {{ $post->remarks }}
                                    </p>

                                </div>
                            </li>
                        </div>
                    @endforeach
                </ul>
                {{ $posts->links('pagination::bootstrap-4') }}
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
                                    <figure id="remove_profile_images">
                                        <img src="{{ asset('/assets/images/noimage.jpeg') }}" class="profile_image" alt="ユーザのプロフィール画像です。">
                                    </figure>
                                @endif
                                </a>
                                <div class="media-body">
                                    <div>
                                        <a href="{{ route('users.show', ['id' => $participation->user->id]) }}">{{ $participation->user->name }}</a>
                                        
                                        @if (Auth::check() && ($participation->user->id != Auth::id()))
                                            
                                            @if (Auth::user()->is_participating($participation->id))
                                                <form method="POST" action="{{ route('participations.cancel', ['id' => $participation->id]) }}">
                                                    {!! method_field('delete') !!}
                                                    {{ csrf_field() }}
                                                    <div class="form-group">
                                                        <input type="submit" value="参加する" class="btn participate-button">
                                                    </div>
                                                </form>
                                            @else
                                                <form method="POST" action="{{ route('participations.participate', ['id' => $participation->id]) }}">
                                                    {{ csrf_field() }}
                                                    <div class="form-group">
                                                        <input type="submit" value="参加する" class="btn participate-button">
                                                    </div>
                                                </form>
                                            @endif  
                                            @if (Auth::check() && !($participation->user->id == Auth::id()))
                                                @if (Auth::user()->is_concerned($participation->id))
                                                    <form method="POST" action="{{ route('concerns.unconcern', ['id' => $participation->id]) }}">
                                                        {!! method_field('delete') !!}
                                                        {{ csrf_field() }}
                                                        <div class="form-group">
                                                            <input type="submit" value="気になる" class="btn concern-button">
                                                        </div>
                                                    </form>
                                                @else
                                                    <form method="POST" action="{{ route('concerns.concern', ['id' => $participation->id]) }}">
                                                        {{ csrf_field() }}
                                                        <div class="form-group">
                                                            <input type="submit" value="気になる" class="btn concern-button">
                                                        </div>
                                                    </form>
                                                @endif  
                                            @endif

                                        @endif

                                    </div>
                                    
                                    <ul class="list-unstyled">
                                        <li>
                                            【{{ $participation->title }}】
                                        </li>
                                        <li>
                                            日時：{{ substr($participation->date_time, 0, 16) . '~' . substr($participation->end_time, 0, 5) }}
                                        </li>
                                        <li>
                                            場所：{{ $participation->place }}
                                        </li>
                                        <li>
                                            住所：{{ $participation->address }}
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
                                            応募締切：{{ substr($participation->deadline, 0, 16) }}
                                        </li>
                                        <li>
                                            募集人数：{{ $participation->people }}
                                        </li>
                                    </ul>
                                    <p>
                                        {{ $participation->remarks }}
                                    </p>

                                </div>
                            </li>
                        </div>
                    @endforeach
                </ul>
                {{ $participations->links('pagination::bootstrap-4') }}
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
                                    <figure id="remove_profile_images">
                                        <img src="{{ asset('/assets/images/noimage.jpeg') }}" class="profile_image" alt="ユーザのプロフィール画像です。">
                                    </figure>
                                @endif
                                </a>
                                <div class="media-body">
                                    <div>
                                        <a href="{{ route('users.show', ['id' => $concern->user->id]) }}">{{ $concern->user->name }}</a>
                                        
                                        @if (Auth::check() && ($concern->user->id != Auth::id()))
                                            
                                            @if (Auth::user()->is_participating($concern->id))
                                                <form method="POST" action="{{ route('participations.cancel', ['id' => $concern->id]) }}">
                                                    {!! method_field('delete') !!}
                                                    {{ csrf_field() }}
                                                    <div class="form-group">
                                                        <input type="submit" value="参加する" class="btn participate-button">
                                                    </div>
                                                </form>
                                            @else
                                                <form method="POST" action="{{ route('participations.participate', ['id' => $concern->id]) }}">
                                                    {{ csrf_field() }}
                                                    <div class="form-group">
                                                        <input type="submit" value="参加する" class="btn participate-button">
                                                    </div>
                                                </form>
                                            @endif  
                                            @if (Auth::check() && !($concern->user->id == Auth::id()))
                                                @if (Auth::user()->is_concerned($concern->id))
                                                    <form method="POST" action="{{ route('concerns.unconcern', ['id' => $concern->id]) }}">
                                                        {!! method_field('delete') !!}
                                                        {{ csrf_field() }}
                                                        <div class="form-group">
                                                            <input type="submit" value="気になる" class="btn concern-button">
                                                        </div>
                                                    </form>
                                                @else
                                                    <form method="POST" action="{{ route('concerns.concern', ['id' => $concern->id]) }}">
                                                        {{ csrf_field() }}
                                                        <div class="form-group">
                                                            <input type="submit" value="気になる" class="btn concern-button">
                                                        </div>
                                                    </form>
                                                @endif  
                                            @endif
                                        @endif

                                    </div>
                                    
                                    <ul class="list-unstyled">
                                        <li>
                                            【{{ $concern->title }}】
                                        </li>
                                        <li>
                                            日時：{{ substr($concern->date_time, 0, 16) . '~' . substr($concern->end_time, 0, 5) }}
                                        </li>
                                        <li>
                                            場所：{{ $concern->place }}
                                        </li>
                                        <li>
                                            住所：{{ $concern->address }}
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
                                            応募締切：{{ substr($concern->deadline, 0, 16) }}
                                        </li>
                                        <li>
                                            募集人数：{{ $concern->people }}
                                        </li>
                                    </ul>
                                    <p>
                                        {{ $concern->remarks }}
                                    </p>

                                </div>
                            </li>
                        </div>
                    @endforeach
                </ul>
                {{ $concerns->links('pagination::bootstrap-4') }}
            @endif 
        </section>
    </section>

@endsection