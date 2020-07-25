@extends ('layouts.postsEditMainArea')

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
                    <label class="d-block" id="date_time-error">【日時】<span class="required">*</span></label>
                    <div>
                        <div class="form-group d-inline-block">
                            @if ($errors->has('year'))
                                <div class="error-target">{{ $errors->first('year') }}</div>
                            @endif                           
                            <select name="year" id="eYear" class="form-control d-inline-block w-auto"></select>                           
                        </div>年
                        <div class="form-group d-inline-block">
                            @if ($errors->has('month'))
                                <div class="error-target">{{ $errors->first('month') }}</div>
                            @endif
                            <select name="month" id="eMonth" class="form-control d-inline-block w-auto"></select>
                        </div>月
                        <div class="form-group d-inline-block">
                            @if ($errors->has('day'))
                                <div class="error-target">{{ $errors->first('day') }}</div>
                            @endif
                            <select name="day" id="eDay" class="form-control d-inline-block w-auto"></select>
                        </div>日
                    </div>
                    <div>
                        <div class="form-group d-inline-block">
                            @if ($errors->has('from_hour'))
                                <div class="error-target">{{ $errors->first('from_hour') }}</div>
                            @endif
                            {!! Form::selectRange('from_hour', 0, 24, $postDateTimeArray[3], ['class' => 'form-control d-inline-block w-auto', 'id' => 'eFrom_hour']) !!}時
                        </div>
                        <div class="form-group d-inline-block">
                            @if ($errors->has('from_minute'))
                                <div class="error-target">{{ $errors->first('from_minute') }}</div>
                            @endif
                            {!! Form::select('from_minute', ['00' => '00', '01' => '01', '02' => '02', '03' => '03', '04' => '04', '05' =>'05', '06' => '06', '07' => '07', '08' => '08', '09' => '09', '10' => '10', '11' => '11', '12' => '12', '13' => '13', '14' => '14', '15' => '15', '16' => '16', '17' => '17', '18' => '18', '19' => '19', '20' => '20', '21' => '21', '22' => '22', '23' => '23', '24' => '24', '25' => '25', '26' => '26', '27' => '27', '28' => '28', '29' => '29', '30' => '30', '31' => '31', '32' => '32', '33' => '33', '34' => '34', '35' => '35', '36' => '36', '37' => '37', '38' => '38', '39' => '39', '40' => '40', '41' => '41', '42' => '42', '43'=> '43', '44' => '44', '45' => '45', '46' => '46', '47' => '47', '48' => '48', '49' => '49', '50' => '50', '51' => '51', '52' => '52', '53' => '53', '54' => '54', '55' => '55', '56' => '56', '57' => '57', '58' => '58', '59' => '59'],
                            $postDateTimeArray[4],['class' => 'form-control d-inline-block w-auto', 'id' => 'eFrom_minute']) !!}分から
                        </div>
                    </div>
                    <div>
                        <div class="form-group d-inline-block">
                            @if ($errors->has('to_year'))
                                <div class="error-target">{{ $errors->first('to_year') }}</div>
                            @endif                           
                            <select name="to_year" id="eTo_Year" class="form-control d-inline-block w-auto"></select>                           
                        </div>年
                        <div class="form-group d-inline-block">
                            @if ($errors->has('to_month'))
                                <div class="error-target">{{ $errors->first('to_month') }}</div>
                            @endif
                            <select name="to_month" id="eTo_Month" class="form-control d-inline-block w-auto"></select>
                        </div>月
                        <div class="form-group d-inline-block">
                            @if ($errors->has('to_day'))
                                <div class="error-target">{{ $errors->first('to_day') }}</div>
                            @endif
                            <select name="to_day" id="eTo_Day" class="form-control d-inline-block w-auto"></select>
                        </div>日
                    </div>
                    <div class="form-group d-inline-block">
                        @if ($errors->has('to_hour'))
                            <div class="error-target">{{ $errors->first('to_hour') }}</div>
                        @endif
                        {!! Form::selectRange('to_hour', 0, 24, $postEndTimeArray[3], ['class' => 'form-control d-inline-block w-auto', 'id' => 'eTo_hour']) !!}時
                    </div>
                    <div class="form-group d-inline-block">
                        @if ($errors->has('to_minute'))
                            <div class="error-target">{{ $errors->first('to_minute') }}</div>
                        @endif
                        {!! Form::select('to_minute', ['00' => '00', '01' => '01', '02' => '02', '03' => '03', '04' => '04', '05' =>'05', '06' => '06', '07' => '07', '08' => '08', '09' => '09', '10' => '10', '11' => '11', '12' => '12', '13' => '13', '14' => '14', '15' => '15', '16' => '16', '17' => '17', '18' => '18', '19' => '19', '20' => '20', '21' => '21', '22' => '22', '23' => '23', '24' => '24', '25' => '25', '26' => '26', '27' => '27', '28' => '28', '29' => '29', '30' => '30', '31' => '31', '32' => '32', '33' => '33', '34' => '34', '35' => '35', '36' => '36', '37' => '37', '38' => '38', '39' => '39', '40' => '40', '41' => '41', '42' => '42', '43'=> '43', '44' => '44', '45' => '45', '46' => '46', '47' => '47', '48' => '48', '49' => '49', '50' => '50', '51' => '51', '52' => '52', '53' => '53', '54' => '54', '55' => '55', '56' => '56', '57' => '57', '58' => '58', '59' => '59'],
                        $postEndTimeArray[4],['class' => 'form-control d-inline-block w-auto', 'id' => 'eTo_minute']) !!}分まで
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
                    <label class="d-block" id="deadline-error">【応募締切】<span class="required">*</span></label>
                    <div>
                        <div class="form-group d-inline-block">
                            @if ($errors->has('deadlineYear'))
                                <div class="error-target">{{ $errors->first('deadlineYear') }}</div>
                            @endif
                            <select name="deadlineYear" id="edYear" class="form-control d-inline-block w-auto"></select>
                        </div>年
                        <div class="form-group d-inline-block">
                            @if ($errors->has('deadlineMonth'))
                                <div class="error-target">{{ $errors->first('deadlineMonth') }}</div>
                            @endif
                            <select name="deadlineMonth" id="edMonth" class="form-control d-inline-block w-auto"></select>                                                       
                        </div>月
                        <div class="form-group d-inline-block">
                            @if ($errors->has('deadlineDay'))
                                <div class="error-target">{{ $errors->first('deadlineDay') }}</div>
                            @endif
                            <select name="deadlineDay" id="edDay" class="form-control d-inline-block w-auto"></select>
                        </div>日
                    </div>
                    <div class="form-group d-inline-block">
                        @if ($errors->has('deadlineHour'))
                            <div class="error-target">{{ $errors->first('deadlineHour') }}</div>
                        @endif
                        {!! Form::selectRange('deadlineHour', 0, 24, $postDeadlineArray[3], ['class' => 'form-control d-inline-block w-auto', 'id' => 'edHour']) !!}時
                    </div>
                    <div class="form-group d-inline-block">
                        @if ($errors->has('deadlineMinute'))
                            <div class="error-target">{{ $errors->first('deadlineMinute') }}</div>
                        @endif
                        {!! Form::select('deadlineMinute', ['00' => '00', '01' => '01', '02' => '02', '03' => '03', '04' => '04', '05' =>'05', '06' => '06', '07' => '07', '08' => '08', '09' => '09', '10' => '10', '11' => '11', '12' => '12', '13' => '13', '14' => '14', '15' => '15', '16' => '16', '17' => '17', '18' => '18', '19' => '19', '20' => '20', '21' => '21', '22' => '22', '23' => '23', '24' => '24', '25' => '25', '26' => '26', '27' => '27', '28' => '28', '29' => '29', '30' => '30', '31' => '31', '32' => '32', '33' => '33', '34' => '34', '35' => '35', '36' => '36', '37' => '37', '38' => '38', '39' => '39', '40' => '40', '41' => '41', '42' => '42', '43'=> '43', '44' => '44', '45' => '45', '46' => '46', '47' => '47', '48' => '48', '49' => '49', '50' => '50', '51' => '51', '52' => '52', '53' => '53', '54' => '54', '55' => '55', '56' => '56', '57' => '57', '58' => '58', '59' => '59'],
                        $postDeadlineArray[4], ['class' => 'form-control d-inline-block w-auto', 'id' => 'edMinute']) !!}分
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
@endsection