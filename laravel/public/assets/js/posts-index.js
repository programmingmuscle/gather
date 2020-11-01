$(".infiniteScroll").on("click", ".detail", (e) => {
  const url = $(e.currentTarget).children("a").attr("href");

  console.log(url);

  window.location.href = url;
});

$(".infiniteScroll").on("click", ".participate-button-full", (e) => {
  e.stopImmediatePropagation();
});

$(".infiniteScroll").on("click", ".button-position", (e) => {
  e.stopImmediatePropagation();
});

$(".infiniteScroll").on("click", ".profile_image", (e) => {
  e.stopImmediatePropagation();
});

$(".infiniteScroll").on("click", ".name-position", (e) => {
  e.stopImmediatePropagation();
});

$(function () {
  concern_data();
});

function concern_data() {
  let canAjax = true;

  $.ajaxSetup({
    headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
  });

  $(".infiniteScroll").on("click", ".concern-button-ajax", (e) => {
    e.stopImmediatePropagation();
    e.preventDefault();

    if (!canAjax) {
      return;
    }

    canAjax = false;

    let postId = $(e.currentTarget).parents(".button-position").attr("data-postId");

    console.log(postId);
    console.log(e.currentTarget);

    let html = `
		<form class="d-inline-block">
			<input type="submit" value="気になる" class="btn unconcern-button unconcern-button-ajax-document d-inline-block">
		</form>
	`;

    $.ajax({
      type: "POST",
      url: "/result/ajax/" + postId + "/concern",
    })
      .done(function () {
        $(e.currentTarget).parents(".button-position").prepend(html);
        $(e.currentTarget).parent().remove();
      })
      .fail(function (jqXHR, textStatus, errorThrown) {
        alert("データの取得に失敗しました。");

        console.log("ajax通信に失敗しました");
        console.log("jqXHR          : " + jqXHR.status);
        console.log("textStatus     : " + textStatus);
        console.log("errorThrown    : " + errorThrown.message);
        console.log("URL            : " + url);
      })
      .always(function () {
        canAjax = true;
      });
  });

  $(".infiniteScroll").on("click", ".concern-button-ajax-document", (e) => {
    e.stopImmediatePropagation();
    e.preventDefault();

    if (!canAjax) {
      return;
    }
    canAjax = false;

    let eCurrentTargetParent = $(e.currentTarget).parent();
    let eCurrentTargetParentParent = $(e.currentTarget).parents(".button-position");
    let postId = $(eCurrentTargetParentParent).attr("data-postId");

    let htmlDocument = `
			<form class="d-inline-block">
				<input type="submit" value="気になる" class="btn unconcern-button unconcern-button-ajax-document d-inline-block">
			</form>
		`;

    console.log(htmlDocument);

    $.ajax({
      type: "POST",
      url: "/result/ajax/" + postId + "/concern",
    })
      .done(function () {
        console.log(e.currentTarget);

        $(eCurrentTargetParentParent).prepend(htmlDocument);
        $(eCurrentTargetParent).remove();
      })
      .fail(function (jqXHR, textStatus, errorThrown) {
        alert("データの取得に失敗しました。");

        console.log("ajax通信に失敗しました");
        console.log("jqXHR          : " + jqXHR.status);
        console.log("textStatus     : " + textStatus);
        console.log("errorThrown    : " + errorThrown.message);
        console.log("URL            : " + url);
      })
      .always(function () {
        canAjax = true;
      });
  });
}

$(function () {
  unconcern_data();
});

function unconcern_data() {
  let canAjax = true;

  $.ajaxSetup({
    headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
  });

  $('.infiniteScroll').on("click", ".unconcern-button-ajax", (e) => {
    e.stopImmediatePropagation();
    e.preventDefault();

    if (!canAjax) {
      return;
    }

    canAjax = false;

    let postId = $(e.currentTarget).parents(".button-position").attr("data-postId");

    console.log(postId);
    console.log(e.currentTarget);

    let html = `
		<form class="d-inline-block">
			<input type="submit" value="気になる" class="btn concern-button concern-button-ajax-document d-inline-block">
		</form>
		`;

    $.ajax({
      type: "POST",
      url: "/result/ajax/" + postId + "/unconcern",
    })
      .done(function () {
        console.log(e.currentTarget);

        $(e.currentTarget).parents(".button-position").prepend(html);
        $(e.currentTarget).parent().remove();
      })
      .fail(function (jqXHR, textStatus, errorThrown) {
        alert("データの取得に失敗しました。");

        console.log("ajax通信に失敗しました");
        console.log("jqXHR          : " + jqXHR.status);
        console.log("textStatus     : " + textStatus);
        console.log("errorThrown    : " + errorThrown.message);
        console.log("URL            : " + url);
      })
      .always(function () {
        canAjax = true;
      });
  });

  $(".infiniteScroll").on("click", ".unconcern-button-ajax-document", (e) => {
    e.stopImmediatePropagation();
    e.preventDefault();

    if (!canAjax) {
      return;
    }

    canAjax = false;

    let eCurrentTargetParent       = $(e.currentTarget).parent();
    let eCurrentTargetParentParent = $(e.currentTarget).parents(".button-position");
    let postId                     = $(eCurrentTargetParentParent).attr("data-postId");

    console.log(postId);

    let htmlDocument = `
			<form class="d-inline-block">
				<input type="submit" value="気になる" class="btn concern-button concern-button-ajax-document d-inline-block">
			</form>
		`;

    console.log(htmlDocument);

    $.ajax({
      type: "POST",
      url: "/result/ajax/" + postId + "/unconcern",
    })
      .done(function () {
        console.log(eCurrentTargetParentParent);

        $(eCurrentTargetParentParent).prepend(htmlDocument);
        $(eCurrentTargetParent).remove();
      })
      .fail(function (jqXHR, textStatus, errorThrown) {
        alert("データの取得に失敗しました。");

        console.log("ajax通信に失敗しました");
        console.log("jqXHR          : " + jqXHR.status);
        console.log("textStatus     : " + textStatus);
        console.log("errorThrown    : " + errorThrown.message);
        console.log("URL            : " + url);
      })
      .always(function () {
        canAjax = true;
      });
  });
}

$('.more').on('click', (e) => {
  e.preventDefault();
});

let ias = new InfiniteAjaxScroll ('.infiniteScroll', {
  item         : ".result_infiniteScroll",
  next         : ".next",
  trigger      : ".more",
  
});
