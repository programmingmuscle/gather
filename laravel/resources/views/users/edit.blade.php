@extends ('layouts.mainArea')

@section ('title')
    アカウント編集
@endsection

@section ('mainArea_content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <form method="POST" action="{{ route('users.update', ['id' => Auth::id()]) }}" class="u-edit-form"  enctype="multipart/form-data">
                    {!! method_field('put') !!}
                    {{ csrf_field() }}
                    <div class="form-group required-note">
                        <span class="required">*</span>が付いている欄は必須項目
                    </div>
                    <div class="form-group">
                        <label for="profile_image">プロフィール画像</label>
                        
                            @if ('$is_image')
                                <figure id="remove_profile_images">
                                    <img src="/storage/profile_images/{{ Auth::id() }}.jpg" class="profile_image" alt="ユーザのプロフィール画像です。">
                                </figure>
                            @endif
                        
                        @if ($errors->has('profile_image'))
                            <div class="error-target">{{ $errors->first('profile_image') }}</div>
                        @endif
                        <label for="profile_image" class="btn btn-success">
                            画像を選択
                            <input type="file" onchange="previewFile()" name="profile_image" id="profile_image" style="display:none">
                        </label>
                    </div>
                    <div class="form-group">
                        <label for="name">選手名<span class="required">*</span></label>
                        @if ($errors->has('name'))
                            <div class="error-target">{{ $errors->first('name') }}</div>
                        @endif
                        <input type="text" name="name" value="{{ $user->name }}" id="name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="email">メールアドレス<span class="required">*</span></label>
                        @if ($errors->has('email'))
                            <div class="error-target">{{ $errors->first('email') }}</div>
                        @endif
                        <input type="email" name="email" value="{{ $user->email }}" id="email" class="form-control">    
                    </div>

                    <div class="form-group">
                        <label for="residence">居住地</label>
                        @if ($errors->has('residence'))
                            <div class="error-target">{{ $errors->first('residence') }}</div>
                        @endif
                        <input type="text" name="residence" placeholder="※地名までとして下さい。" value="{{ $user->residence }}" id="residence" class="form-control">    
                    </div>
                    <div class="form-group">
                        <label for="gender">性別</label>
                        @if ($errors->has('gender'))
                            <div class="error-target">{{ $errors->first('gender') }}</div>
                        @endif
                        <select name="gender" id="gender" class="form-control">
                            @if ($user->gender != null)
                                <option value="{{ $user->gender }}">{{ $user->gender }}</option>
                            @endif
                            <option value=""></option>
                            <option value="男性">男性</option>
                            <option value="女性">女性</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="age">年齢</label>
                        @if ($errors->has('age'))
                            <div class="error-target">{{ $errors->first('age') }}</div>
                        @endif
                        <select name="age" id="age" class="form-control">
                            @if ($user->age != null)
                                <option value="{{ $user->age }}" class="option-border">{{ $user->age }}</option>
                            @endif
                            <option value=""></option>
                            <option value="10代">10代</option>
                            <option value="20代">20代</option>
                            <option value="30代">30代</option>
                            <option value="40代">40代</option>
                            <option value="50代">50代</option>
                            <option value="60代以上">60代以上</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="experience">野球歴</label>
                        @if ($errors->has('experience'))
                            <div class="error-target">{{ $errors->first('experience') }}</div>
                        @endif
                        <select name="experience" id="experience" class="form-control">
                            @if ($user->experience != null)
                                <option value="{{ $user->experience }}">{{ $user->experience }}</option>
                            @endif
                            <option value=""></option>
                            <option value="5年未満">5年未満</option>
                            <option value="5~10年">5~10年</option>
                            <option value="10年以上">10年以上</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="position">ポジション</label>
                        @if ($errors->has('position'))
                            <div class="error-target">{{ $errors->first('position') }}</div>
                        @endif
                        <select name="position" id="position" class="form-control">
                            @if ($user->position != null)
                                <option value="{{ $user->positon }}">{{ $user->position }}</option>
                            @endif
                            <option value=""></option>
                            <option value="投手">投手</option>
                            <option value="捕手">捕手</option>
                            <option value="一塁手">一塁手</option>
                            <option value="二塁手">二塁手</option>
                            <option value="三塁手">三塁手</option>
                            <option value="遊撃手">遊撃手</option>
                            <option value="左翼手">左翼手</option>
                            <option value="中堅手">中堅手</option>
                            <option value="右翼手">右翼手</option>
                            <option value="内野全般">内野全般</option>
                            <option value="外野全般">外野全般</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="introduction">自己紹介</label>
                        @if ($errors->has('introduction'))
                            <div class="error-target">{{ $errors->first('introduction') }}</div>
                        @endif
                        <textarea name="introduction" id="introduction" class="form-control">{{ $user->introduction }}</textarea>   
                    </div>
                    <div class="explain">上記内容に変更してよろしいでしょうか？</div>
                    <div class="form-group">
                        <label for="password" id="password-error">パスワード<span class="required">*</span></label>
                        @if ($errors->has('password'))
                            <div class="error-target">{{ $errors->first('password') }}</div>
                        @endif
                        <input type="password" name="password" id="password" class="form-control">    
                    </div>
                    <div class="complete-button form-group">
                        <input type="submit" value="完了" class="btn btn-success">
                    </div>
                </form>

                @if ($user->id === Auth::id())
                    <div class="explain-link">※<a href="{{ route('users.deleteWindow', ['id' => Auth::id()]) }}" class="explain-link-destroy">アカウント削除</a></div>
                @endif

                <div class="explain-link"><a href="{{ route('users.show', ['id' => Auth::id()]) }}">マイアカウント</a>に戻る</div>
            </div>
        </div>
    </div>
@endsection