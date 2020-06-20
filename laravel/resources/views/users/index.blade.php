@extends ('layouts.mainArea')

@section ('title')
    選手一覧
@endsection

@section ('mainArea_content')
      
    <form>
        {{ csrf_field() }}               
        <div class="container search-box">
            <div class="row">
                <div class="col-9">
                    <input type="text" name="keyword" value="{{ $keyword }}" class="form-control" placeholder="キーワードで選手を検索">              
                </div>
                <div class="col-3">
                    <input type="submit" value="検索" class="btn btn-success">
                </div>
            </div>
        </div>
    </form>
                
    @if (count($users) > 0)
        <ul class="list-unstyled">
            @foreach ($users as $user)
                <div class="list-border">
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