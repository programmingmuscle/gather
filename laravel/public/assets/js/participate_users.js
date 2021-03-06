$('.infiniteScroll').on("click", ".detail", (e) => {
  const url = $(e.currentTarget).children("a").attr("href");

  console.log(url);

  window.location.href = url;
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
  follow_data();
});

function follow_data() {
  let canAjax = true;

  $.ajaxSetup({
    headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
  });

  $('.infiniteScroll').on("click", ".follow-button-ajax", (e) => {
    e.stopImmediatePropagation();
    e.preventDefault();

    if (!canAjax) {
      return;
    }
    canAjax = false;

    let userId = $(e.currentTarget).parents(".button-position").attr("data-userId");

    console.log(userId);
    console.log(e.currentTarget);

    let html = `
		<form class="d-inline-block">
			<input type="submit" value="フォロー中" class="btn unfollow-button unfollow-button-ajax-document d-inline-block">
		</form>
	`;

    $.ajax({
      type: "POST",
      url: "/result/ajax/" + userId + "/follow",
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

  $('.infiniteScroll').on("click", ".follow-button-ajax-document", (e) => {
    e.stopImmediatePropagation();
    e.preventDefault();

    if (!canAjax) {
      return;
    }
    canAjax = false;

    let eCurrentTargetParent       = $(e.currentTarget).parent();
    let eCurrentTargetParentParent = $(e.currentTarget).parents(".button-position");
    let userId                     = $(eCurrentTargetParentParent).attr("data-userId");

    let htmlDocument = `
			<form class="d-inline-block">
				<input type="submit" value="フォロー中" class="btn unfollow-button unfollow-button-ajax-document d-inline-block">
			</form>
		`;

    console.log(htmlDocument);

    $.ajax({
      type: "POST",
      url: "/result/ajax/" + userId + "/follow",
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
  unfollow_data();
});

function unfollow_data() {
  let canAjax = true;

  $.ajaxSetup({
    headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
  });

  $('.infiniteScroll').on("click", ".unfollow-button-ajax", (e) => {
    e.stopImmediatePropagation();
    e.preventDefault();

    if (!canAjax) {
      return;
    }

    canAjax = false;

    let userId = $(e.currentTarget).parents(".button-position").attr("data-userId");

    console.log(userId);
    console.log(e.currentTarget);

    let html = `
			<form method="POST" class="d-inline-block">
				<input type="submit" value="フォロー" class="btn follow-button follow-button-ajax-document d-inline-block">
			</form>
		`;

    $.ajax({
      type: "POST",
      url: "/result/ajax/" + userId + "/unfollow",
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

  $('.infiniteScroll').on("click", ".unfollow-button-ajax-document", (e) => {
    e.stopImmediatePropagation();
    e.preventDefault();

    if (!canAjax) {
      return;
    }

    canAjax = false;

    let eCurrentTargetParent       = $(e.currentTarget).parent();
    let eCurrentTargetParentParent = $(e.currentTarget).parents(".button-position");
    let userId                     = $(eCurrentTargetParentParent).attr("data-userId");

    console.log(userId);

    let htmlDocument = `
			<form class="d-inline-block">
				<input type="submit" value="フォロー" class="btn follow-button follow-button-ajax-document d-inline-block">
			</form>
		`;

    console.log(htmlDocument);

    $.ajax({
      type: "POST",
      url: "/result/ajax/" + userId + "/unfollow",
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
