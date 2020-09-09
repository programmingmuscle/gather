$('.detail').on('click', (e) => {
    const url = $(e.currentTarget).children('a').attr('href');
    console.log(url);
    window.location.href = url;
});

$('.participate-button-full').on('click', (e) => {
    e.stopPropagation();
});

$(function() {
    concern_data();
});

function concern_data() {
    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
    });
    
    $('.concern-button-ajax').on('click', (e) => {
        e.stopPropagation();
        e.preventDefault();
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
            success: () => {
                $(e.currentTarget).parent().parent().prepend(html);
                $(e.currentTarget).parent().remove();
            },
            error: (jqXHR, textStatus, errorThrown) => {
                alert("データの取得に失敗しました。");
                console.log("ajax通信に失敗しました");
                console.log("jqXHR          : " + jqXHR.status);
                console.log("textStatus     : " + textStatus);
                console.log("errorThrown    : " + errorThrown.message);
                console.log("URL            : " + url);
            }
        });        
    });

    $('.button-position').on('click', '.concern-button-ajax-document', (e) => {
        e.stopPropagation();
        e.preventDefault();
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
            success: () => {
                console.log(e.currentTarget);
                $(eCurrentTargetParentParent).prepend(htmlDocument);
                $(eCurrentTargetParent).remove();
            },
            error: (jqXHR, textStatus, errorThrown) => {
                alert("データの取得に失敗しました。");
                console.log("ajax通信に失敗しました");
                console.log("jqXHR          : " + jqXHR.status);
                console.log("textStatus     : " + textStatus);
                console.log("errorThrown    : " + errorThrown.message);
                console.log("URL            : " + url);
            }
        });
    });
}

$(function() {
    unconcern_data();
});

function unconcern_data() {
    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
    });
    
    $('.unconcern-button-ajax').on('click', (e) => {
        e.stopPropagation();
        e.preventDefault();
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
            success: () => {
                console.log(e.currentTarget);
                $(e.currentTarget).parent().parent().prepend(html);
                $(e.currentTarget).parent().remove();
            },
            error: (jqXHR, textStatus, errorThrown) => {
                alert("データの取得に失敗しました。");
                console.log("ajax通信に失敗しました");
                console.log("jqXHR          : " + jqXHR.status);
                console.log("textStatus     : " + textStatus);
                console.log("errorThrown    : " + errorThrown.message);
                console.log("URL            : " + url);
            }
        });
    });

    $('.button-position').on('click', '.unconcern-button-ajax-document', (e) => {
        e.stopPropagation();
        e.preventDefault();
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
            success: () => {
                console.log(eCurrentTargetParentParent);
                $(eCurrentTargetParentParent).prepend(htmlDocument);
                $(eCurrentTargetParent).remove();
            },
            error: (jqXHR, textStatus, errorThrown) => {
                alert("データの取得に失敗しました。");
                console.log("ajax通信に失敗しました");
                console.log("jqXHR          : " + jqXHR.status);
                console.log("textStatus     : " + textStatus);
                console.log("errorThrown    : " + errorThrown.message);
                console.log("URL            : " + url);
            }
        });
    });
}