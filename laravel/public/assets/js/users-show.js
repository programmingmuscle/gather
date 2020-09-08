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
        success: data => {
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
        }
    });
}

$(function() {
    follow_data();
});

function follow_data() {
    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
    });
    
    $('.follow-button-ajax').on('click', (e) => {
        e.preventDefault();
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
            success: () => {
                $(e.currentTarget).parent().parent().prepend(html);
                $(e.currentTarget).parent().remove();
                get_data();
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

    $(document).on('click', '.follow-button-ajax-document', (e) => {
        e.preventDefault();
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
            success: () => {
                console.log(e.currentTarget);
                $(eCurrentTargetParentParent).prepend(htmlDocument);
                $(eCurrentTargetParent).remove();
                get_data();
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
    unfollow_data();
});

function unfollow_data() {
    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
    });
    
    $('.unfollow-button-ajax').on('click', (e) => {
        e.preventDefault();
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
            success: () => {
                console.log(e.currentTarget);
                $(e.currentTarget).parent().parent().prepend(html);
                $(e.currentTarget).parent().remove();
                get_data();
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

    $(document).on('click', '.unfollow-button-ajax-document', (e) => {
        e.preventDefault();
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
            success: () => {
                console.log(eCurrentTargetParentParent);
                $(eCurrentTargetParentParent).prepend(htmlDocument);
                $(eCurrentTargetParent).remove();
                get_data();
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
