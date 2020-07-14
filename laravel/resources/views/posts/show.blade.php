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
                <div class="button-position ml-3">
                    @include ('participations.participate_button')
                    @include ('concerns.concern_button')
                </div>
            @endif

        </div>
    </div>
@endsection