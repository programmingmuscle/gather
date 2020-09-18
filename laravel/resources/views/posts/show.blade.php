@extends ('layouts.mainArea')

@section ('title')
    <a href="javascript:history.back()" class="back">←</a><div class="d-inline-block">投稿詳細</div>
@endsection

@section ('mainArea_content')

    @if (session('participate-flashmessage'))
        <div class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">参加しました</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>当ページにて投稿者にメッセージを送信し当日の予定を調整しましょう！</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

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

            @if ($post->user->id != Auth::id())
                @include ('concerns.concern_button')
            @endif

            <div class="accordion ajaxTargetAdd">
                @if (count($users) > 0)
                    <div class="ml-3 mb-3 mt-3 accordion-title dropdown-toggle ajaxTargetRemove">参加者<span class="badge badge-primary badge-pill">{{ $count_participate_users }}</span></div>
                @else
                    <div class="ml-3 mb-3 mt-3 ajaxTargetRemove">参加者<span class="badge badge-secondary badge-pill">{{ $count_participate_users }}</span></div>
                @endif

                <div class="ml-3 accordion-content">
                    <ul class="list-unstyled">
                        @if (count($users) > 0)
                            @foreach ($users as $user)
                                <li class="mb-1 participate_users_data">

                                    @if ($user->profile_image != '')
                                        <a href="{{ route('users.show', ['id' => $user->id]) }}" class="Profile_imageLink">
                                            <img src="/storage/profile_images/{{ $user->id }}.jpg" class="profile_image" alt="ユーザのプロフィール画像です。">
                                        </a>
                                        <a href="{{ route('users.show', ['id' => $user->id]) }}">{{ $user->name }}</a>                                        
                                    @else
                                        <a href="{{ route('users.show', ['id' => $user->id]) }}" class="Profile_imageLink">
                                            <img src="{{ asset('/assets/images/noimage.jpeg') }}" class="profile_image" alt="ユーザのプロフィール画像です。">
                                        </a>
                                        <a href="{{ route('users.show', ['id' => $user->id]) }}">{{ $user->name }}</a>                                        
                                    @endif

                                </li>
                            @endforeach
                        @endif
                    </ul>
                    <a href="{{ route('posts.participateUsers', ['id' => $post->id]) }}" class="d-inline-block pt-3 mb-3">参加者一覧</a>へ
                </div>
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
                        <input type="submit" value="送信" class="btn btn-success" id="ajaxPost" data-user_id="{{ Auth::id() }}" data-post_id="{{ $post->id }}" data-user_name="{{ Auth::user()->name }}" data-user_profile_image="{{ Auth::user()->profile_image }}">
                    </div>
                </div>
            </div>
        @else
            <div class="message-box">
                <p class="text-center mb-0"><a href="{{ route('login') }}">ログイン</a>してメッセージを送信</p>
            </div>
        @endif
        
    </form>
    <ul class="list-unstyled message-data" id="ajaxGet" data-post_id="{{ $post->id }}">

        @if (count($messages) > 0)
            @foreach ($messages as $message)
                <div class="list-border message-list" data-messageId="{{ $message->id }}">
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
                            <a href="{{ route('users.show', ['id' => $message->user->id]) }}" class="message-position d-inline-block">{{ $message->user_name }}</a>
                            <p class="message-word-break">
                                {!! nl2br(e($message->content)) !!}
                            </p>
                            <div class="message-float">

                                @if ($message->created_at != $message->updated_at)
                                    <p class="message_content text-right mr-0">編集済み</p>
                                @endif

                                @if ($message->user->id == Auth::id())
                                    <div class="text-right">
                                        <span class="message-edit-color">編集</span>|<span class="message-delete-color">削除</span>
                                    </div>
                                @endif

                                <div class="message-color">
                                    {{ $message->created_at->format('Y/n/j G:i') }}
                                </div>
                            </div>
                        </div>
                    </li>
                </div>
            @endforeach
        @else
            <p class="message_content" id="messageZero">メッセージはこちらに表示されます</p>
        @endif 
 
    </ul>

    @section ('js')
        <script src="{{ asset('/assets/js/posts-show.js') }}"></script>
    @endsection

@endsection