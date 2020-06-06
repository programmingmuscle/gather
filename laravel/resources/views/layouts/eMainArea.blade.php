@extends ('layouts.eApp')

@section('content')
    <div class="main-area">
        <div class="title">

            @yield ('title')

        </div>
        <div class="content">
            
            @if (count($errors) > 0)
                <p class="error-message alert alert-danger list-unstyled" role="alert">入力に問題があります。再入力して下さい。</p>
            @endif

            @yield ('mainArea_content')

        </div>
    </div>
@endsection