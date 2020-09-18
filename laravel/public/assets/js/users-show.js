const showTab = (selector) => {
    $('.tabs-menu li').removeClass('active');
    $(`.tabs-menu a[href="${ selector }"]`)
        .parent('li')
        .addClass('active');

    $('.tabs-content section').hide();
    $(selector).show();
};

$('.tabs-menu a').on('click', (e) => {
    e.preventDefault();

    const selector = $(e.target).attr('href');
    showTab(selector);
});

showTab('#tabs-timelines');

$('.flash_message').fadeOut(5000);

$('.detail').on('click', (e) => {
    const url = $(e.currentTarget).children('a').attr('href');
    console.log(url);
    window.location.href = url; 
});

$('.button-position').on('click', (e) => {
    e.stopPropagation();
});

$('.profile_image').on('click', (e) => {
    e.stopPropagation();
});

$('.name-position').on('click', (e) => {
    e.stopPropagation();
});

function get_data() {
    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
    });
    let userId = $('#ajax').attr('data-userId');
    console.log(userId);
    $.ajax({
        type: 'GET',
        url:"/result/ajax/" + userId,
        dataType: "json",
    }).done(function(data) {
        if (data.count_followers != 0) {
            let followers = `
                <a href="/users/${userId}/followers" class="ajaxTargetRemove">フォロワー：${data.count_followers}</a>
            `;
            $('.ajaxTargetRemove').remove();
            $('.ajaxTargetAdd').after(followers);
            console.log(data.count_followers);
        } else {
            followers = `
                <span class="noneFollow ajaxTargetRemove">フォロワー：0</span>
            `;
            $('.ajaxTargetRemove').remove();
            $('.ajaxTargetAdd').after(followers);
            console.log(data.count_followers);
        }
    });
}

$(function() {
    follow_data();
});

function follow_data() {
    let canAjax = true;
    
    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
    });
    
    $('.follow-button-ajax').on('click', (e) => {
        e.preventDefault();

        if (!canAjax) {
            return;
        }
        canAjax = false;

        let userId = $(e.currentTarget).parent().parent().attr('data-userId');
        console.log(userId);
        console.log(e.currentTarget);
        let html = `
            <form class="d-inline-block">
                <input type="submit" value="フォロー中" class="btn unfollow-button unfollow-button-ajax-document d-inline-block">
            </form>
        `;

        $.ajax({
            type: 'POST',
            url: "/result/ajax/" + userId + "/follow",
        }).done(function() {
                $(e.currentTarget).parent().parent().prepend(html);
                $(e.currentTarget).parent().remove();
                get_data();
        }).fail(function(jqXHR, textStatus, errorThrown) {
            alert("データの取得に失敗しました。");
            console.log("ajax通信に失敗しました");
            console.log("jqXHR          : " + jqXHR.status);
            console.log("textStatus     : " + textStatus);
            console.log("errorThrown    : " + errorThrown.message);
            console.log("URL            : " + url);
        }).always(function() {
            canAjax = true;
        });        
    });

    $(document).on('click', '.follow-button-ajax-document', (e) => {
        e.preventDefault();

        if (!canAjax) {
            return;
        }
        canAjax = false;

        let userId = $(e.currentTarget).parent().parent().attr('data-userId');
        let eCurrentTargetParent = $(e.currentTarget).parent();
        let eCurrentTargetParentParent = $(e.currentTarget).parent().parent();
        let htmlDocument = `
            <form class="d-inline-block">
                <input type="submit" value="フォロー中" class="btn unfollow-button unfollow-button-ajax-document d-inline-block">
            </form>
        `;
        console.log(htmlDocument);

        $.ajax({
            type: 'POST',
            url: "/result/ajax/" + userId + "/follow",
        }).done(function() {
            console.log(e.currentTarget);
            $(eCurrentTargetParentParent).prepend(htmlDocument);
            $(eCurrentTargetParent).remove();
            get_data();
        }).fail(function(jqXHR, textStatus, errorThrown) {
            alert("データの取得に失敗しました。");
            console.log("ajax通信に失敗しました");
            console.log("jqXHR          : " + jqXHR.status);
            console.log("textStatus     : " + textStatus);
            console.log("errorThrown    : " + errorThrown.message);
            console.log("URL            : " + url);
        }).always(function() {
            canAjax = true;
        });
    });
}

$(function() {
    unfollow_data();
});

function unfollow_data() {
    let canAjax = true;

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
    });
    
    $('.unfollow-button-ajax').on('click', (e) => {
        e.preventDefault();

        if (!canAjax) {
            return;
        }
        canAjax = false;

        let userId = $(e.currentTarget).parent().parent().attr('data-userId');
        console.log(userId);
        console.log(e.currentTarget);
        let html = `
            <form method="POST" class="d-inline-block">
                <input type="submit" value="フォロー" class="btn follow-button follow-button-ajax-document d-inline-block">
            </form>
        `;

        $.ajax({
            type: 'POST',
            url: "/result/ajax/" + userId + "/unfollow",
        }).done(function() {
            console.log(e.currentTarget);
            $(e.currentTarget).parent().parent().prepend(html);
            $(e.currentTarget).parent().remove();
            get_data();
        }).fail(function(jqXHR, textStatus, errorThrown) {
            alert("データの取得に失敗しました。");
            console.log("ajax通信に失敗しました");
            console.log("jqXHR          : " + jqXHR.status);
            console.log("textStatus     : " + textStatus);
            console.log("errorThrown    : " + errorThrown.message);
            console.log("URL            : " + url);
        }).always(function() {
            canAjax = true;
        });        
    });

    $(document).on('click', '.unfollow-button-ajax-document', (e) => {
        e.preventDefault();

        if (!canAjax) {
            return;
        }
        canAjax = false;

        let userId = $(e.currentTarget).parent().parent().attr('data-userId');
        let eCurrentTargetParent = $(e.currentTarget).parent();
        let eCurrentTargetParentParent = $(e.currentTarget).parent().parent();
        console.log(userId);
        let htmlDocument = `
            <form class="d-inline-block">
                <input type="submit" value="フォロー" class="btn follow-button follow-button-ajax-document d-inline-block">
            </form>
        `;
        console.log(htmlDocument);

        $.ajax({
            type: 'POST',
            url: "/result/ajax/" + userId + "/unfollow",
        }).done(function() {
            console.log(eCurrentTargetParentParent);
            $(eCurrentTargetParentParent).prepend(htmlDocument);
            $(eCurrentTargetParent).remove();
            get_data();
        }).fail(function(jqXHR, textStatus, errorThrown) {
            alert("データの取得に失敗しました。");
            console.log("ajax通信に失敗しました");
            console.log("jqXHR          : " + jqXHR.status);
            console.log("textStatus     : " + textStatus);
            console.log("errorThrown    : " + errorThrown.message);
            console.log("URL            : " + url);
        }).always(function() {
            canAjax = true;
        });        
    });
}

$(function() {
    concern_data();
});

function concern_data() {
    let canAjax = true;

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
    });
    
    $('.concern-button-ajax').on('click', (e) => {
        e.stopPropagation();
        e.preventDefault();

        if (!canAjax) {
            return;
        }
        canAjax = false;

        let postId = $(e.currentTarget).parent().parent().attr('data-postId');
        console.log(postId);
        console.log(e.currentTarget);
        let html = `
            <form class="d-inline-block">
                <input type="submit" value="気になる" class="btn unconcern-button unconcern-button-ajax-document d-inline-block">
            </form>
        `;

        $.ajax({
            type: 'POST',
            url: "/result/ajax/" + postId + "/concern",
        }).done(function() {
            $(e.currentTarget).parent().parent().prepend(html);
            $(e.currentTarget).parent().remove();
        }).fail(function(jqXHR, textStatus, errorThrown) {
            alert("データの取得に失敗しました。");
            console.log("ajax通信に失敗しました");
            console.log("jqXHR          : " + jqXHR.status);
            console.log("textStatus     : " + textStatus);
            console.log("errorThrown    : " + errorThrown.message);
            console.log("URL            : " + url);
        }).always(function() {
            canAjax = true;
        });       
    });

    $('.button-position').on('click', '.concern-button-ajax-document', (e) => {
        e.stopPropagation();
        e.preventDefault();

        if (!canAjax) {
            return;
        }
        canAjax = false;

        let postId = $(e.currentTarget).parent().parent().attr('data-postId');
        let eCurrentTargetParent = $(e.currentTarget).parent();
        let eCurrentTargetParentParent = $(e.currentTarget).parent().parent();
        let htmlDocument = `
            <form class="d-inline-block">
                <input type="submit" value="気になる" class="btn unconcern-button unconcern-button-ajax-document d-inline-block">
            </form>
        `;
        console.log(htmlDocument);

        $.ajax({
            type: 'POST',
            url: "/result/ajax/" + postId + "/concern",
        }).done(function() {
            console.log(e.currentTarget);
            $(eCurrentTargetParentParent).prepend(htmlDocument);
            $(eCurrentTargetParent).remove();
        }).fail(function(jqXHR, textStatus, errorThrown) {
            alert("データの取得に失敗しました。");
            console.log("ajax通信に失敗しました");
            console.log("jqXHR          : " + jqXHR.status);
            console.log("textStatus     : " + textStatus);
            console.log("errorThrown    : " + errorThrown.message);
            console.log("URL            : " + url);
        }).always(function() {
            canAjax = true;
        });
    });
}

$(function() {
    unconcern_data();
});

function unconcern_data() {
    let canAjax = true;

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
    });
    
    $('.unconcern-button-ajax').on('click', (e) => {
        e.stopPropagation();
        e.preventDefault();

        if (!canAjax) {
            return;
        }
        canAjax = false;

        let postId = $(e.currentTarget).parent().parent().attr('data-postId');
        console.log(postId);
        console.log(e.currentTarget);
        let html = `
            <form class="d-inline-block">
                <input type="submit" value="気になる" class="btn concern-button concern-button-ajax-document d-inline-block">
            </form>
        `;

        $.ajax({
            type: 'POST',
            url: "/result/ajax/" + postId + "/unconcern",
        }).done(function() {
            console.log(e.currentTarget);
            $(e.currentTarget).parent().parent().prepend(html);
            $(e.currentTarget).parent().remove();
        }).fail(function(jqXHR, textStatus, errorThrown) {
            alert("データの取得に失敗しました。");
            console.log("ajax通信に失敗しました");
            console.log("jqXHR          : " + jqXHR.status);
            console.log("textStatus     : " + textStatus);
            console.log("errorThrown    : " + errorThrown.message);
            console.log("URL            : " + url);
        }).always(function() {
            canAjax = true;
        });
    });

    $('.button-position').on('click', '.unconcern-button-ajax-document', (e) => {
        e.stopPropagation();
        e.preventDefault();

        if (!canAjax) {
            return;
        }
        canAjax = false;

        let postId = $(e.currentTarget).parent().parent().attr('data-postId');
        let eCurrentTargetParent = $(e.currentTarget).parent();
        let eCurrentTargetParentParent = $(e.currentTarget).parent().parent();
        console.log(postId);
        let htmlDocument = `
            <form class="d-inline-block">
                <input type="submit" value="気になる" class="btn concern-button concern-button-ajax-document d-inline-block">
            </form>
        `;
        console.log(htmlDocument);

        $.ajax({
            type: 'POST',
            url: "/result/ajax/" + postId + "/unconcern",
        }).done(function() {
            console.log(eCurrentTargetParentParent);
            $(eCurrentTargetParentParent).prepend(htmlDocument);
            $(eCurrentTargetParent).remove();
        }).fail(function(jqXHR, textStatus, errorThrown) {
            alert("データの取得に失敗しました。");
            console.log("ajax通信に失敗しました");
            console.log("jqXHR          : " + jqXHR.status);
            console.log("textStatus     : " + textStatus);
            console.log("errorThrown    : " + errorThrown.message);
            console.log("URL            : " + url);
        }).always(function() {
            canAjax = true;
        });
    });
}
