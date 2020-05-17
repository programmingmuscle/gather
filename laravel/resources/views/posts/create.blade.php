@extends ('layouts.mainArea')

@section ('title')
    投稿作成
@endsection

@section('mainArea_content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <form method="POST" action="{{ route('posts.store') }}">
                    {{ csrf_field() }}
                    <div class="form-group required-note">
                        <span class="required">*</span>が付いている欄は必須項目
                    </div>
                    <div class="form-group">
                        <label for="title">【タイトル】<span class="required">*</span></label>
                        @if ($errors->has('title'))
                            <div class="error-target">{{ $errors->first('title') }}</div>
                        @endif
                        <input type="text" name="title" placeholder="例：キャッチボールしませんか？" value="{{ old('title') }}" id="title" class="form-control">
                    </div>
                    <label class="d-block">【日時】<span class="required">*</span></label>
                    <div>
                        <div class="form-group d-inline-block">
                            @if ($errors->has('year'))
                                <div class="error-target">{{ $errors->first('year') }}</div>
                            @endif
                            {!! Form::selectRange('year', date('Y'), date('Y')+1, old('year'), ['class' => 'form-control d-inline-block w-auto']) !!}年
                        </div>
                        <div class="form-group d-inline-block">
                            @if ($errors->has('month'))
                                <div class="error-target">{{ $errors->first('month') }}</div>
                            @endif                     
                            {!! Form::select('month', ['01' => '01', '02' => '02', '03' => '03', '04' => '04', '05' =>'05', '06' => '06', '07' => '07', '08' => '08', '09' => '09', '10' => '10', '11' => '11', '12' => '12'],
                            old('month'),['class' => 'form-control d-inline-block w-auto']) !!}月
                        </div>
                        <div class="form-group d-inline-block">
                            @if ($errors->has('day'))
                                <div class="error-target">{{ $errors->first('month') }}</div>
                            @endif                    
                            {!! Form::select('day', ['01' => '01', '02' => '02', '03' => '03', '04' => '04', '05' =>'05', '06' => '06', '07' => '07', '08' => '08', '09' => '09', '10' => '10', '11' => '11', '12' => '12', '13' => '13', '14' => '14', '15' => '15', '16' => '16', '17' => '17', '18' => '18', '19' => '19', '20' => '20', '21' => '21', '22' => '22', '23' => '23', '24' => '24', '25' => '25', '26' => '26', '27' => '27', '28' => '28', '29' => '29', '30' => '30', '31' => '31'],
                            old('day'),['class' => 'form-control d-inline-block w-auto']) !!}日
                        </div>
                    </div>
                    <div>
                        <div class="form-group d-inline-block">
                            @if ($errors->has('from_hour'))
                                <div class="error-target">{{ $errors->first('from_hour') }}</div>
                            @endif                 
                            {!! Form::select('from_hour', ['00' => '00', '01' => '01', '02' => '02', '03' => '03', '04' => '04', '05' =>'05', '06' => '06', '07' => '07', '08' => '08', '09' => '09', '10' => '10', '11' => '11', '12' => '12', '13' => '13', '14' => '14', '15' => '15', '16' => '16', '17' => '17', '18' => '18', '19' => '19', '20' => '20', '21' => '21', '22' => '22', '23' => '23'],
                            old('from_hour'),['class' => 'form-control d-inline-block w-auto']) !!}時
                        </div>
                        <div class="form-group d-inline-block">
                            @if ($errors->has('from_minute'))
                                <div class="error-target">{{ $errors->first('from_minute') }}</div>
                            @endif
                            {!! Form::select('from_minute', ['00' => '00', '01' => '01', '02' => '02', '03' => '03', '04' => '04', '05' =>'05', '06' => '06', '07' => '07', '08' => '08', '09' => '09', '10' => '10', '11' => '11', '12' => '12', '13' => '13', '14' => '14', '15' => '15', '16' => '16', '17' => '17', '18' => '18', '19' => '19', '20' => '20', '21' => '21', '22' => '22', '23' => '23', '24' => '24', '25' => '25', '26' => '26', '27' => '27', '28' => '28', '29' => '29', '30' => '30', '31' => '31', '32' => '32', '33' => '33', '34' => '34', '35' => '35', '36' => '36', '37' => '37', '38' => '38', '39' => '39', '40' => '40', '41' => '41', '42' => '42', '43'=> '43', '44' => '44', '45' => '45', '46' => '46', '47' => '47', '48' => '48', '49' => '49', '50' => '50', '51' => '51', '52' => '52', '53' => '53', '54' => '54', '55' => '55', '56' => '56', '57' => '57', '58' => '58', '59' => '59'],
                            old('from_minute'),['class' => 'form-control d-inline-block w-auto']) !!}分から
                        </div>
                    </div>
                    <div class="form-group d-inline-block">
                        @if ($errors->has('to_hour'))
                            <div class="error-target">{{ $errors->first('to_hour') }}</div>
                        @endif
                        {!! Form::select('to_hour', ['00' => '00', '01' => '01', '02' => '02', '03' => '03', '04' => '04', '05' =>'05', '06' => '06', '07' => '07', '08' => '08', '09' => '09', '10' => '10', '11' => '11', '12' => '12', '13' => '13', '14' => '14', '15' => '15', '16' => '16', '17' => '17', '18' => '18', '19' => '19', '20' => '20', '21' => '21', '22' => '22', '23' => '23', '24' => '24'],
                        old('to_hour'),['class' => 'form-control d-inline-block w-auto']) !!}時
                    </div>
                    <div class="form-group d-inline-block">
                        @if ($errors->has('to_minute'))
                            <div class="error-target">{{ $errors->first('to_minute') }}</div>
                        @endif
                        {!! Form::select('to_minute', ['00' => '00', '01' => '01', '02' => '02', '03' => '03', '04' => '04', '05' =>'05', '06' => '06', '07' => '07', '08' => '08', '09' => '09', '10' => '10', '11' => '11', '12' => '12', '13' => '13', '14' => '14', '15' => '15', '16' => '16', '17' => '17', '18' => '18', '19' => '19', '20' => '20', '21' => '21', '22' => '22', '23' => '23', '24' => '24', '25' => '25', '26' => '26', '27' => '27', '28' => '28', '29' => '29', '30' => '30', '31' => '31', '32' => '32', '33' => '33', '34' => '34', '35' => '35', '36' => '36', '37' => '37', '38' => '38', '39' => '39', '40' => '40', '41' => '41', '42' => '42', '43'=> '43', '44' => '44', '45' => '45', '46' => '46', '47' => '47', '48' => '48', '49' => '49', '50' => '50', '51' => '51', '52' => '52', '53' => '53', '54' => '54', '55' => '55', '56' => '56', '57' => '57', '58' => '58', '59' => '59'],
                        old('to_minute'),['class' => 'form-control d-inline-block w-auto']) !!}分まで
                    </div>
                    <div class="form-group">
                        <label for="place">【場所】<span class="required">*</span></label>
                        @if ($errors->has('place'))
                            <div class="error-target">{{ $errors->first('place') }}</div>
                        @endif
                        <input type="text" name="place" placeholder="例：○×□公園野球場" value="{{ old('place') }}" id="place" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="address">【住所】<span class="required">*</span></label>
                        @if ($errors->has('address'))
                            <div class="error-target">{{ $errors->first('address') }}</div>
                        @endif
                        <input type="text" name="address" placeholder="※「場所」の詳細住所を記入" value="{{ old('address') }}" id="address" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="reservation">【場所利用予約】<span class="required">*</span></label>
                        @if ($errors->has('reservation'))
                            <div class="error-target">{{ $errors->first('reservation') }}</div>
                        @endif
                        {!! Form::select('reservation', ['不要' => '不要', '予約済み' => '予約済み', '未予約' => '未予約'], old('reservation'), ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        <label for="expense">【参加費用】<span class="required">*</span></label>
                        @if ($errors->has('expense'))
                            <div class="error-target">{{ $errors->first('expense') }}</div>
                        @endif
                        <input type="text" name="expense" placeholder="例1：保険代1,000円　例２：なし" value="{{ old('expense') }}" id="expense" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="ball">【使用球】<span class="required">*</span></label>
                        @if ($errors->has('ball'))
                            <div class="error-target">{{ $errors->first('ball') }}</div>
                        @endif
                        {!! Form::select('ball', ['軟式' => '軟式', '硬式' => '硬式'], old('ball'), ['class' => 'form-control']) !!}
                    </div>                    
                    <label class="d-block">【応募締切】<span class="required">*</span></label>
                    <div>
                        <div class="form-group d-inline-block">
                            @if ($errors->has('deadlineYear'))
                                <div class="error-target">{{ $errors->first('deadlineYear') }}</div>
                            @endif
                            {!! Form::selectRange('deadlineYear', date('Y'), date('Y')+1, old('deadlineYear'), ['class' => 'form-control d-inline-block w-auto']) !!}年
                        </div>
                        <div class="form-group d-inline-block">
                            @if ($errors->has('deadlineMonth'))
                                <div class="error-target">{{ $errors->first('deadlineMonth') }}</div>
                            @endif                    
                            {!! Form::select('deadlineMonth', ['01' => '01', '02' => '02', '03' => '03', '04' => '04', '05' =>'05', '06' => '06', '07' => '07', '08' => '08', '09' => '09', '10' => '10', '11' => '11', '12' => '12'],
                            old('deadlineMonth'),['class' => 'form-control d-inline-block w-auto']) !!}月
                        </div>
                        <div class="form-group d-inline-block">
                            @if ($errors->has('deadlineDay'))
                                <div class="error-target">{{ $errors->first('deadlineDay') }}</div>
                            @endif
                            {!! Form::select('deadlineDay', ['01' => '01', '02' => '02', '03' => '03', '04' => '04', '05' =>'05', '06' => '06', '07' => '07', '08' => '08', '09' => '09', '10' => '10', '11' => '11', '12' => '12', '13' => '13', '14' => '14', '15' => '15', '16' => '16', '17' => '17', '18' => '18', '19' => '19', '20' => '20', '21' => '21', '22' => '22', '23' => '23', '24' => '24', '25' => '25', '26' => '26', '27' => '27', '28' => '28', '29' => '29', '30' => '30', '31' => '31'],
                            old('deadlineDay'),['class' => 'form-control d-inline-block w-auto']) !!}日
                        </div>
                    </div>
                    <div class="form-group d-inline-block">
                        @if ($errors->has('deadlineHour'))
                            <div class="error-target">{{ $errors->first('deadlineHour') }}</div>
                        @endif
                        {!! Form::select('deadlineHour', ['00' => '00', '01' => '01', '02' => '02', '03' => '03', '04' => '04', '05' =>'05', '06' => '06', '07' => '07', '08' => '08', '09' => '09', '10' => '10', '11' => '11', '12' => '12', '13' => '13', '14' => '14', '15' => '15', '16' => '16', '17' => '17', '18' => '18', '19' => '19', '20' => '20', '21' => '21', '22' => '22', '23' => '23', '24' => '24'],
                        old('deadlineHour'),['class' => 'form-control d-inline-block w-auto']) !!}時
                    </div>
                    <div class="form-group d-inline-block">
                        @if ($errors->has('deadlineMinute'))
                            <div class="error-target">{{ $errors->first('deadlineMinute') }}</div>
                        @endif
                        {!! Form::select('deadlineMinute', ['00' => '00', '01' => '01', '02' => '02', '03' => '03', '04' => '04', '05' =>'05', '06' => '06', '07' => '07', '08' => '08', '09' => '09', '10' => '10', '11' => '11', '12' => '12', '13' => '13', '14' => '14', '15' => '15', '16' => '16', '17' => '17', '18' => '18', '19' => '19', '20' => '20', '21' => '21', '22' => '22', '23' => '23', '24' => '24', '25' => '25', '26' => '26', '27' => '27', '28' => '28', '29' => '29', '30' => '30', '31' => '31', '32' => '32', '33' => '33', '34' => '34', '35' => '35', '36' => '36', '37' => '37', '38' => '38', '39' => '39', '40' => '40', '41' => '41', '42' => '42', '43'=> '43', '44' => '44', '45' => '45', '46' => '46', '47' => '47', '48' => '48', '49' => '49', '50' => '50', '51' => '51', '52' => '52', '53' => '53', '54' => '54', '55' => '55', '56' => '56', '57' => '57', '58' => '58', '59' => '59'],
                        old('deadlineMinute'), ['class' => 'form-control d-inline-block w-auto']) !!}分
                    </div>
                    <div class="form-group">
                        <label for="people">【募集人数】<span class="required">*</span></label>
                        @if ($errors->has('people'))
                            <div class="error-target">{{ $errors->first('people') }}</div>
                        @endif
                        {!! Form::select('people', ['1人' => '1人', '2人' => '2人', '3人' => '3人', '4人' => '4人', '5人' => '5人', '6人' => '6人', '7人' => '7人', '8人' => '8人', '9人' => '9人', '10人' => '10人', '11人' => '11人', '12人' => '12人', '13人'=> '13人', '14人' => '14人', '15人' => '15人', '16人' => '16人', '17人' => '17人', '18人' => '18人', '19人' => '19人', '20人' => '20人', '21人' => '21人', '22人' => '22人', '23人' => '23人', '24人' => '24人', '25人' => '25人', '26人' => '26人', '27人' => '27人', '28人' => '28人', '29人' => '29人', '30人' => '30人', '31人' => '31人', '32人' => '32人', '33人' => '33人', '34人' => '34人', '35人' => '35人', '36人' => '36人', '37人' => '37人', '38人' => '38人', '39人' => '39人', '40人' => '40人'],
                        old('people'), ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        <label for="remarks">【備考】</label>
                        @if ($errors->has('remarks'))
                            <div class="error-target">{{ $errors->first('remarks') }}</div>
                        @endif 
                        <textarea name="remarks" id="remarks" class="form-control" placeholder="例：グローブのみご持参下さい。">{{ old('remarks') }}</textarea>   
                    </div>
                    <div class="complete-button form-group">
                        <input type="submit" value="完了" class="btn btn-success">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection