$('.u-edit-form').on('submit', (e) => {
    const password = $('#password').val();

    if(password === '') {
        e.preventDefault();

        $('#remove-error-content').remove();

        $('.remove-error-password').remove();

        $('<p class="error-message alert alert-danger list-unstyled" id="remove-error-content" role="alert">入力に問題があります。再入力して下さい。</p>').prependTo('#content');
        
        $('<div class="error-target remove-error-password">パスワードを入力して下さい。</div>').insertAfter('#password-error');

        $('html, body').animate({ scrollTop: 0 }, 600);
    } else {
        $('.remove-error-password').remove();
    }


});