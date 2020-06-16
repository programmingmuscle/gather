@extends ('layouts.mainArea')

@section ('title')
   投稿詳細
@endsection

@section ('mainArea_content')
    <div class="media show_content">
        <a href="{{ route('users.show', ['id' => $post->user->id]) }}">
            @if ($post->user->profile_image != '')
                <figure>
                    <img src="/storage/profile_images/{{ $post->user->id }}.jpg" class="profile_image" alt="ユーザのプロフィール画像です。">
                </figure>
            @else
                <figure id="remove_profile_images">
                    <img src="{{ asset('/assets/images/noimage.jpeg') }}" class="profile_image" alt="ユーザのプロフィール画像です。">
                </figure>
            @endif
        </a>
        <div class="media-body">
        <a href="{{ route('users.show', ['id' => $post->user->id]) }}">{{ $post->user->name }}</a>
            
            @if (Auth::check() && !($post->user->id == Auth::id()))
               
                @include ('participations.participate_button')
                @include ('concerns.concern_button')

            @endif

            @if ($post->user->id == Auth::id())
                <a href="{{ route('posts.edit', ['id' => $post->id]) }}">編集</a>
            @endif

            @include ('commons.postContentList')

        </div>
    </div>
@endsection