@extends ('layouts.app')

@section('content')
    <div class="main-area">
        <div class="title">

            @yield ('title')

        </div>
        <div class="content" id="content">

            @if (session('success'))
                <div class="alert alert-success flash_message" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            
            @if (count($errors) > 0)
                <p class="error-message alert alert-danger list-unstyled" id="remove-error-content" role="alert">入力に問題があります。再入力して下さい。</p>
            @endif

            @yield ('mainArea_content')

        </div>
    </div>
@endsection