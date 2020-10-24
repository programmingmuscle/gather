/*$(".u-edit-form").on("submit", (e) => {
  const name     = $("#name").val();
  const email    = $("#email").val();
  const password = $("#password").val();

  if (name === "") {
    e.preventDefault();

    $("#remove-error-content").remove();
    $(".remove-error-name").remove();

    $(
      '<p class="error-message alert alert-danger list-unstyled" id="remove-error-content" role="alert">入力に問題があります。再入力して下さい。</p>'
    ).prependTo("#content");

    $(
      '<div class="error-target remove-error-name">選手名を入力して下さい。</div>'
    ).insertAfter("#name-error");

    $("html, body").animate({ scrollTop: 0 }, 600);
  } else {
    $(".remove-error-name").remove();
  }

  if (email === "") {
    e.preventDefault();

    $("#remove-error-content").remove();
    $(".remove-error-email").remove();

    $(
      '<p class="error-message alert alert-danger list-unstyled" id="remove-error-content" role="alert">入力に問題があります。再入力して下さい。</p>'
    ).prependTo("#content");

    $(
      '<div class="error-target remove-error-email">メールアドレスを入力して下さい。</div>'
    ).insertAfter("#email-error");

    $("html, body").animate({ scrollTop: 0 }, 600);
  } else {
    $(".remove-error-email").remove();
  }

  if (password === "") {
    e.preventDefault();

    $("#remove-error-content").remove();
    $(".remove-error-password").remove();

    $(
      '<p class="error-message alert alert-danger list-unstyled" id="remove-error-content" role="alert">入力に問題があります。再入力して下さい。</p>'
    ).prependTo("#content");

    $(
      '<div class="error-target remove-error-password">パスワードを入力して下さい。</div>'
    ).insertAfter("#password-error");

    $("html, body").animate({ scrollTop: 0 }, 600);
  } else {
    $(".remove-error-password").remove();
  }
});

function previewFile() {
  const preview = document.querySelector("img");
  const file    = document.querySelector("input[type=file]").files[0];
  const reader  = new FileReader();

  reader.addEventListener(
    "load",
    function () {
      preview.src = reader.result;
    },
    false
  );

  if (file) {
    reader.readAsDataURL(file);
  }
}
*/