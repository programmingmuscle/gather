$('.accordion-title').on('click', () => {

    if (!$('.accordion-content').is(':visible')) {
        $('.accordion-content').slideDown();
    } else {
        $('.accordion-content').slideUp();
    }
});

$('.message-form').on('submit', (e) => {
    const messageContent = $('#messageContent').val();

    if (messageContent === '') {
        e.preventDefault();

        $('#remove-error-content').remove();

        $('.remove-error-messageContent').remove();

        $('.remove-error-messageContentStr').remove();

        $('<p class="error-message alert alert-danger list-unstyled" id="remove-error-content" role="alert">入力に問題があります。再入力して下さい。</p>').prependTo('#content');
        
        $('<div class="error-target remove-error-messageContent">空のメッセージは送信できません。</div>').insertAfter('#messageContent-error');
  
        $('html, body').animate({ scrollTop: 0 }, 600);

    }  else if (messageContent.length > 191) {
        e.preventDefault();

        $('#remove-error-content').remove();

        $('.remove-error-messageContent').remove();

        $('.remove-error-messageContentStr').remove();

        $('<p class="error-message alert alert-danger list-unstyled" id="remove-error-content" role="alert">入力に問題があります。再入力して下さい。</p>').prependTo('#content');
        
        $('<div class="error-target remove-error-messageContentStr">メッセージは191文字以内として下さい。</div>').insertAfter('#messageContent-error');
  
        $('html, body').animate({ scrollTop: 0 }, 600);

    } else {
        $('#remove-error-content').remove();

        $('.remove-error-messageContent').remove();

        $('.remove-error-messageContentStr').remove();
    }
});