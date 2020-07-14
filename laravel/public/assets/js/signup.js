$('.signup-form').on('submit', (e) => {
    const name = $('#name').val();
    const email = $('#email').val();
    const password = $('#password').val();
    const passwordLength = password.length;
    console.log(passwordLength);
    const password_confirmation = $('#password_confirmation').val();

    if(name === '') {
      e.preventDefault();

      $('#remove-error-content').remove();

      $('.remove-error-name').remove();

      $('<p class="error-message alert alert-danger list-unstyled" id="remove-error-content" role="alert">入力に問題があります。再入力して下さい。</p>').prependTo('#content');
      
      $('<div class="error-target remove-error-name">選手名を入力して下さい。</div>').insertAfter('#name-error');

      $('html, body').animate({ scrollTop: 0 }, 600);
    } else {
        $('.remove-error-name').remove();
    }

    if(email === '') {
        e.preventDefault();
  
        $('#remove-error-content').remove();
  
        $('.remove-error-email').remove();
  
        $('<p class="error-message alert alert-danger list-unstyled" id="remove-error-content" role="alert">入力に問題があります。再入力して下さい。</p>').prependTo('#content');
        
        $('<div class="error-target remove-error-email">メールアドレスを入力して下さい。</div>').insertAfter('#email-error');
  
        $('html, body').animate({ scrollTop: 0 }, 600);
      } else {
          $('.remove-error-email').remove();
      }

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

      if(passwordLength <= 5 && password !== '') {
        e.preventDefault();

        $('#remove-error-content').remove();
  
        $('.remove-error-passwordLength').remove();
  
        $('<p class="error-message alert alert-danger list-unstyled" id="remove-error-content" role="alert">入力に問題があります。再入力して下さい。</p>').prependTo('#content');
        
        $('<div class="error-target remove-error-passwordLength">パスワードは６文字以上として下さい。</div>').insertAfter('.passwordLength-error');
  
        $('html, body').animate({ scrollTop: 0 }, 600);
      } else {
          $('.remove-error-passwordLength').remove();
      }

      if(password_confirmation === '') {
        e.preventDefault();
  
        $('#remove-error-content').remove();
  
        $('.remove-error-password_confirmation').remove();
  
        $('<p class="error-message alert alert-danger list-unstyled" id="remove-error-content" role="alert">入力に問題があります。再入力して下さい。</p>').prependTo('#content');
        
        $('<div class="error-target remove-error-password_confirmation">確認用パスワードを入力して下さい。</div>').insertAfter('#password_confirmation-error');
  
        $('html, body').animate({ scrollTop: 0 }, 600);
      } else {
          $('.remove-error-password_confirmation').remove();
      }
});