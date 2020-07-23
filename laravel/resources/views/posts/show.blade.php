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

            @include ('participations.participate_button')

            @include ('concerns.concern_button')

            <div class="accordion">
                @if (count($users) > 0)
                    <div class="ml-3 mb-3 mt-3 accordion-title dropdown-toggle">参加者<span class="badge badge-primary badge-pill">{{ $count_participate_users }}</span></div>
                @else
                    <div class="ml-3 mb-3 mt-3">参加者<span class="badge badge-secondary badge-pill">{{ $count_participate_users }}</span></div>
                @endif

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
                        <a href="{{ route('posts.participateUsers', ['id' => $post->id]) }}" class="d-inline-block pt-3 mb-3">参加者一覧</a>へ
                    </div>

                @endif
            </div>
            
        </div>
    </div>
    <form method="POST" action="{{ route('messages.store', ['id' => $post->id]) }}" class="message-form">
        {{ csrf_field() }}

        @if (Auth::check())
            <div class="media message-box">
                    <a href="{{ route('users.show', ['id' => Auth::id()]) }}">
                        @if (Auth::user()->profile_image != '')
                            <img src="/storage/profile_images/{{ Auth::id() }}.jpg" class="profile_image" alt="ユーザのプロフィール画像です。">
                        @else
                        <img src="{{ asset('/assets/images/noimage.jpeg') }}" class="profile_image" alt="ユーザのプロフィール画像です。">
                        @endif
                    </a>
                    <div class="media-body">
                        <div id="messageContent-error"></div>
                        @if ($errors->has('content'))
                            <div class="error-target">{{ $errors->first('content') }}</div>
                        @endif
                        <textarea name="content" id="messageContent" class="form-control" placeholder="メッセージを送信して連絡を取り合いましょう！">{{ old('content') }}</textarea>
                        <div class="message-button">
                            <input type="submit" value="送信" class="btn btn-success">
                        </div>
                    </div>
            </div>
        @else
            <div class="message-box">
                <p class="text-center mb-0"><a href="{{ route('login') }}">ログイン</a>してメッセージを送信</p>
            </div>
        @endif
    </form>

    @if (count($messages) > 0)
        <ul class="list-unstyled">

            @foreach ($messages as $message)
                <div class="list-border">
                    <li class="media list">
                        <a href="{{ route('users.show', ['id' => $message->user->id]) }}">
                            
                            @if ($message->user->profile_image != '')
                                <figure>
                                    <img src="/storage/profile_images/{{ $message->user->id }}.jpg" class="profile_image" alt="ユーザのプロフィール画像です。">
                                </figure>
                            @else
                                <figure>
                                    <img src="{{ asset('/assets/images/noimage.jpeg') }}" class="profile_image" alt="ユーザのプロフィール画像です。">
                                </figure>
                            @endif
                            
                        </a>
                        <div class="media-body">              
                            <a href="{{ route('users.show', ['id' => $message->user->id]) }}" class="message-position d-inline-block">{{ $message->user->name }}</a>
                            <p class="message-word-break">
                                {{ $message->content }}
                            </p>
                            <div class="message-time-float d-inline-block message-color">
                                {{ $message->created_at }}
                            </div>
                        </div>
                    </li>
                </div>
            @endforeach

        </ul>
    @else
        <p class="message_content">メッセージはこちらに表示されます</p>
    @endif

    {{ $messages->links('pagination::bootstrap-4') }}
@endsection