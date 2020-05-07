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
                        <label for="title">タイトル<span class="required">*</span></label>
                        @if ($errors->has('title'))
                            <div class="error-target">{{ $errors->first('title') }}</div>
                        @endif
                        <input type="text" name="title" placeholder="例：キャッチボールしませんか？" value="{{ old('title') }}" id="title" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="date_time">日時<span class="required">*</span></label>
                        @if ($errors->has('date_time'))
                            <div class="error-target">{{ $errors->first('date_time') }}</div>
                        @endif
                        <input type="text" name="date_time" value="{{ old('date_time') }}" id="date_time" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="place">場所<span class="required">*</span></label>
                        @if ($errors->has('place'))
                            <div class="error-target">{{ $errors->first('place') }}</div>
                        @endif
                        <input type="text" name="place" placeholder="例：○×□公園野球場" value="{{ old('place') }}" id="place" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="address">住所<span class="required">*</span></label>
                        @if ($errors->has('address'))
                            <div class="error-target">{{ $errors->first('address') }}</div>
                        @endif
                        <input type="text" name="address" placeholder="「場所」の住所を詳しく記載してください" value="{{ old('address') }}" id="address" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="reservation">場所利用予約<span class="required">*</span></label>
                        @if ($errors->has('reservation'))
                            <div class="error-target">{{ $errors->first('reservation') }}</div>
                        @endif
                        <input type="text" name="reservation" value="{{ old('reservation') }}" id="reservation" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="expense">参加費用<span class="required">*</span></label>
                        @if ($errors->has('expense'))
                            <div class="error-target">{{ $errors->first('expense') }}</div>
                        @endif
                        <input type="text" name="expense" placeholder="例1：1,000円　例２：なし" value="{{ old('expense') }}" id="expense" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="ball">使用球<span class="required">*</span></label>
                        @if ($errors->has('ball'))
                            <div class="error-target">{{ $errors->first('ball') }}</div>
                        @endif
                        <input type="text" name="ball" value="{{ old('ball') }}" id="ball" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="deadline">応募締切<span class="required">*</span></label>
                        @if ($errors->has('deadline'))
                            <div class="error-target">{{ $errors->first('deadline') }}</div>
                        @endif
                        <input type="text" name="deadline" value="{{ old('deadline') }}" id="deadline" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="people">募集人数<span class="required">*</span></label>
                        @if ($errors->has('people'))
                            <div class="error-target">{{ $errors->first('people') }}</div>
                        @endif
                        <input type="text" name="people" value="{{ old('people') }}" id="people" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="remarks">備考</label>
                        @if ($errors->has('remarks'))
                            <div class="error-target">{{ $errors->first('remarks') }}</div>
                        @endif 
                        <textarea name="remarks" id="remarks" class="form-control">{{ old('remarks') }}</textarea>   
                    </div>
                    <div class="complete-button form-group">
                        <input type="submit" value="完了" class="btn btn-success">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection