@extends ('layouts.mainArea')

@section ('title')
   投稿詳細
@endsection

@section ('mainArea_content')
    <div class="media show_content">
        <a href="{{ route('users.show', ['id' => $post->user->id]) }}">

            @if ($post->user->profile_image != '')
                <img src="/storage/profile_images/{{ $post->user->id }}.jpg" class="profile_image" alt="ユーザのプロフィール画像です。">
            @else
                <img src="{{ asset('/assets/images/noimage.jpeg') }}" class="profile_image" alt="ユーザのプロフィール画像です。">
            @endif

        </a>
        <div class="media-body">
            <div class="d-flex justify-content-between">              
                <a href="{{ route('users.show', ['id' => $post->user->id]) }}" class="name-position d-inline-block">{{ $post->user->name }}</a>

                @if ($post->user->id == Auth::id())
                    <div class="button-position button-float">
                        <a href="{{ route('posts.edit', ['id' => $post->id]) }}" class="edit-button btn">投稿を編集</a>
                    </div>
                @endif               
                
            </div>

            @include ('commons.postContentList')
            
            @if (Auth::check() && !($post->user->id == Auth::id()))
                <div class="button-position ml-3 mb-3">
                    @include ('participations.participate_button')
                    @include ('concerns.concern_button')
                </div>
            @endif

            <div class="accordion">
                <div class="ml-3 accordion-title dropdown-toggle">参加者</div>

                @if (count($users) > 0)
                    <div class="ml-3 accordion-content">
                        <ul class="list-unstyled">

                            @foreach ($users as $user)
                                <li class="mb-1">

                                        @if ($user->profile_image != '')
                                            <a href="{{ route('users.show', ['id' => $user->id]) }}">
                                                <img src="/storage/profile_images/{{ $user->id }}.jpg" class="profile_image" alt="ユーザのプロフィール画像です。">
                                            </a>
                                            <a href="{{ route('users.show', ['id' => $user->id]) }}">{{ $user->name }}</a>
                                            <br>
                                        @else
                                            <a href="{{ route('users.show', ['id' => $user->id]) }}">
                                                <img src="{{ asset('/assets/images/noimage.jpeg') }}" class="profile_image" alt="ユーザのプロフィール画像です。">
                                            </a>
                                            <a href="{{ route('users.show', ['id' => $user->id]) }}">{{ $user->name }}</a>
                                            <br>
                                        @endif

                                </li>
                            @endforeach

                        </ul>
                    </div>

                @endif
            </div>
            
        </div>
    </div>
@endsection