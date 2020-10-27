$(".p-edit-form").on("submit", (e) => {
  const title     = $("#title").val();
  const place     = $("#place").val();
  const address   = $("#address").val();
  const expense   = $("#expense").val();
  const date_time = $("#date_time").val();
  const end_time  = $("#end_time").val();
  const deadline  = $("#deadline").val();
  const date      = new Date(date_time);
  const end       = new Date(end_time);
  const dDate     = new Date(deadline);

  if (date >= end) {
    e.preventDefault();

    $("#remove-error-content").remove();
    $(".remove-error-dateEnd").remove();

    $(
      '<p class="error-message alert alert-danger list-unstyled" id="remove-error-content" role="alert">入力に問題があります。再入力して下さい。</p>'
    ).prependTo("#content");

    $(
      '<div class="error-target remove-error-dateEnd">終了日時は開始日時より後の日時として下さい。</div>'
    ).insertAfter("#end_time-error");

    $("html, body").animate({ scrollTop: 0 }, 600);
  } else {
    $(".remove-error-dateEnd").remove();
  }

  if (date <= dDate) {
    e.preventDefault();

    $("#remove-error-content").remove();
    $(".remove-error-dateDeadline").remove();

    $(
      '<p class="error-message alert alert-danger list-unstyled" id="remove-error-content" role="alert">入力に問題があります。再入力して下さい。</p>'
    ).prependTo("#content");

    $(
      '<div class="error-target remove-error-dateDeadline">締切日時は開始日時より前の日時として下さい。</div>'
    ).insertAfter("#deadline-error");

    $("html, body").animate({ scrollTop: 0 }, 600);
  } else {
    $(".remove-error-dateDeadline").remove();
  }

  if (date_time === "") {
    e.preventDefault();

    $("#remove-error-content").remove();
    $(".remove-error-date_time").remove();

    $(
      '<p class="error-message alert alert-danger list-unstyled" id="remove-error-content" role="alert">入力に問題があります。再入力して下さい。</p>'
    ).prependTo("#content");

    $(
      '<div class="error-target remove-error-date_time">開始日時を入力して下さい。</div>'
    ).insertAfter("#date_time-error");

    $("html, body").animate({ scrollTop: 0 }, 600);
  } else {
    $(".remove-error-date_time").remove();
  }

  if (end_time === "") {
    e.preventDefault();

    $("#remove-error-content").remove();
    $(".remove-error-end_time").remove();

    $(
      '<p class="error-message alert alert-danger list-unstyled" id="remove-error-content" role="alert">入力に問題があります。再入力して下さい。</p>'
    ).prependTo("#content");

    $(
      '<div class="error-target remove-error-end_time">終了日時を入力して下さい。</div>'
    ).insertAfter("#end_time-error");

    $("html, body").animate({ scrollTop: 0 }, 600);
  } else {
    $(".remove-error-end_time").remove();
  }

  if (deadline === "") {
    e.preventDefault();

    $("#remove-error-content").remove();
    $(".remove-error-deadline").remove();

    $(
      '<p class="error-message alert alert-danger list-unstyled" id="remove-error-content" role="alert">入力に問題があります。再入力して下さい。</p>'
    ).prependTo("#content");

    $(
      '<div class="error-target remove-error-deadline">締切日時を入力して下さい。</div>'
    ).insertAfter("#deadline-error");

    $("html, body").animate({ scrollTop: 0 }, 600);
  } else {
    $(".remove-error-deadline").remove();
  }

  if (title === "") {
    e.preventDefault();

    $("#remove-error-content").remove();
    $(".remove-error-title").remove();

    $(
      '<p class="error-message alert alert-danger list-unstyled" id="remove-error-content" role="alert">入力に問題があります。再入力して下さい。</p>'
    ).prependTo("#content");

    $(
      '<div class="error-target remove-error-title">タイトルを入力して下さい。</div>'
    ).insertAfter("#title-error");

    $("html, body").animate({ scrollTop: 0 }, 600);
  } else {
    $(".remove-error-title").remove();
  }

  if (place === "") {
    e.preventDefault();

    $("#remove-error-content").remove();
    $(".remove-error-place").remove();

    $(
      '<p class="error-message alert alert-danger list-unstyled" id="remove-error-content" role="alert">入力に問題があります。再入力して下さい。</p>'
    ).prependTo("#content");

    $(
      '<div class="error-target remove-error-place">場所を入力して下さい。</div>'
    ).insertAfter("#place-error");

    $("html, body").animate({ scrollTop: 0 }, 600);
  } else {
    $(".remove-error-place").remove();
  }

  if (address === "") {
    e.preventDefault();

    $("#remove-error-content").remove();
    $(".remove-error-address").remove();

    $(
      '<p class="error-message alert alert-danger list-unstyled" id="remove-error-content" role="alert">入力に問題があります。再入力して下さい。</p>'
    ).prependTo("#content");

    $(
      '<div class="error-target remove-error-address">住所を入力して下さい。</div>'
    ).insertAfter("#address-error");

    $("html, body").animate({ scrollTop: 0 }, 600);
  } else {
    $(".remove-error-address").remove();
  }

  if (expense === "") {
    e.preventDefault();

    $("#remove-error-content").remove();
    $(".remove-error-expense").remove();

    $(
      '<p class="error-message alert alert-danger list-unstyled" id="remove-error-content" role="alert">入力に問題があります。再入力して下さい。</p>'
    ).prependTo("#content");

    $(
      '<div class="error-target remove-error-expense">参加費用を入力して下さい。</div>'
    ).insertAfter("#expense-error");

    $("html, body").animate({ scrollTop: 0 }, 600);
  } else {
    $(".remove-error-expense").remove();
  }
});
