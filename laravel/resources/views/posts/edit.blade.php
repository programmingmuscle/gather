@extends ('layouts.mainArea')

@section ('title')
    投稿編集
@endsection

@section ('mainArea_content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <form method="POST" action="{{ route('posts.update', ['id' => $post->id]) }}" class="p-edit-form">
                    {!! method_field('put') !!}
                    {{ csrf_field() }}
                    <div class="form-group required-note">
                        <span class="required">*</span>が付いている欄は必須項目
                    </div>
                    <div class="form-group">
                        <label for="title" id="title-error">【タイトル】<span class="required">*</span></label>
                        @if ($errors->has('title'))
                            <div class="error-target">{{ $errors->first('title') }}</div>
                        @endif
                        <input type="text" name="title" placeholder="例：キャッチボールしませんか？" value="{{ $post->title }}" id="title" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="date_time" id="date_time-error">【開始日時】<span class="required">*</span></label>
                        @if ($errors->has('date_time'))
                            <div class="error-target">{{ $errors->first('date_time') }}</div>
                        @endif                           
                        <input type="datetime-local" id="date_time" name="date_time" value="{{ str_replace(' ', 'T', $post->date_time) }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="end_time" id="end_time-error">【終了日時】<span class="required">*</span></label>
                        @if ($errors->has('end_time'))
                            <div class="error-target">{{ $errors->first('end_time') }}</div>
                        @endif                           
                        <input type="datetime-local" id="end_time" name="end_time" value="{{ str_replace(' ', 'T', $post->end_time) }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="place" id="place-error">【場所】<span class="required">*</span></label>
                        @if ($errors->has('place'))
                            <div class="error-target">{{ $errors->first('place') }}</div>
                        @endif
                        <input type="text" name="place" placeholder="例：○×□公園野球場" value="{{ $post->place }}" id="place" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="address" id="address-error">【住所】<span class="required">*</span></label>
                        @if ($errors->has('address'))
                            <div class="error-target">{{ $errors->first('address') }}</div>
                        @endif
                        <input type="text" name="address" placeholder="※「場所」の詳細住所を記入" value="{{ $post->address }}" id="address" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="reservation">【場所利用予約】<span class="required">*</span></label>
                        @if ($errors->has('reservation'))
                            <div class="error-target">{{ $errors->first('reservation') }}</div>
                        @endif
                        {!! Form::select('reservation', ['不要' => '不要', '予約済み' => '予約済み', '未予約' => '未予約'], $post->reservation, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        <label for="expense" id="expense-error">【参加費用】<span class="required">*</span></label>
                        @if ($errors->has('expense'))
                            <div class="error-target">{{ $errors->first('expense') }}</div>
                        @endif
                        <input type="text" name="expense" placeholder="例1：保険代1,000円　例２：なし" value="{{ $post->expense }}" id="expense" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="ball">【使用球】<span class="required">*</span></label>
                        @if ($errors->has('ball'))
                            <div class="error-target">{{ $errors->first('ball') }}</div>
                        @endif
                        {!! Form::select('ball', ['軟式' => '軟式', '硬式' => '硬式'], $post->ball, ['class' => 'form-control']) !!}
                    </div>                    
                    <div class="form-group">
                        <label for="deadline" id="deadline-error">【応募締切】<span class="required">*</span></label>
                        @if ($errors->has('deadline'))
                            <div class="error-target">{{ $errors->first('deadline') }}</div>
                        @endif                           
                        <input type="datetime-local" id="deadline" name="deadline" value="{{ str_replace(' ', 'T', $post->deadline) }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="people">【募集人数】<span class="required">*</span></label>
                        @if ($errors->has('people'))
                            <div class="error-target">{{ $errors->first('people') }}</div>
                        @endif
                        {!! Form::selectRange('people', 1, 40, $post->people, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        <label for="remarks">【備考】</label>
                        @if ($errors->has('remarks'))
                            <div class="error-target">{{ $errors->first('remarks') }}</div>
                        @endif 
                        <textarea name="remarks" id="remarks" class="form-control" placeholder="例：グローブのみご持参下さい。">{{ $post->remarks }}</textarea>   
                    </div>
                    <div class="complete-button form-group">
                        <input type="submit" value="完了" class="btn btn-success">
                    </div>
                </form>

                @if ($post->user->id === Auth::id())
                    <div class="explain-link">※<a href="{{ route('posts.deleteWindow', ['id' => $post->id]) }}" class="explain-link-destroy">投稿削除</a></div>
                @endif

                <div class="explain-link"><a href="{{ route('posts.show', ['id' => $post->id]) }}">投稿詳細</a>に戻る</div>
            </div>
        </div>
    </div>

    @section('js')
        <script src="{{ asset('/assets/js/posts-edit.js') }}"></script>
    @endsection
    
@endsection