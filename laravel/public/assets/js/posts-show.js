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

$(window).on('load', () => {
    $('.modal').modal('show');
});

$(function() {
    get_data();
});

function get_data() {
    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
    });
    const post_id = $('#ajaxGet').data('post_id');
    $.ajax({
        type: 'POST',
        url: "/result/ajax/" + post_id,
        dataType: "json",
        success: data => {
            $('.message-list').remove();
            for (let i = 0; i < data.messages.length; i++) {
                if (data.messages[i].user_profile_image != undefined) {
                    let user_profile_image = `
                        <figure>
                            <img src="/storage/profile_images/${data.messages[i].user_id}.jpg" class="profile_image" alt="ユーザのプロフィール画像です。">
                        </figure>
                    `;
                    let created_at = new Date(data.messages[i].created_at);
                    let year = created_at.getFullYear();
                    let month = created_at.getMonth() + 1;                    
                    let date = created_at.getDate();
                    let hour = created_at.getHours();
                    let minute = ("0" + created_at.getMinutes()).slice(-2);
                    let created_atFormat = `${year}/${month}/${date} ${hour}:${minute}`;
                    console.log(created_atFormat);
                    let html = `
                        <div class="list-border message-list">
                            <li class="media list">
                                <a href="/users/${data.messages[i].user_id}">
                                    ${user_profile_image}
                                </a>
                                <div class="media-body">              
                                <a href="/users/${data.messages[i].user_id}" class="message-position d-inline-block">${data.messages[i].user_name}</a>
                                    <p class="message-word-break">
                                        ${data.messages[i].content}
                                    </p>
                                    <div class="message-time-float d-inline-block message-color">
                                        ${created_atFormat}
                                    </div>
                                </div>
                            </li>
                        </div>
                    `;
                    console.log(html);
                    $('.message-data').append(html);
                } else {
                    let user_profile_image = `
                        <figure>
                            <img src="/assets/images/noimage.jpeg" class="profile_image" alt="ユーザのプロフィール画像です。">
                        </figure>
                        `;
                        let created_at = new Date(data.messages[i].created_at);
                        let year = created_at.getFullYear();
                        let month = created_at.getMonth() + 1;
                        let date = created_at.getDate();
                        let hour = created_at.getHours();
                        let minute = ("0" + created_at.getMinutes()).slice(-2);
                        let created_atFormat = `${year}/${month}/${date} ${hour}:${minute}`;
                        console.log(created_atFormat);
                        let html = `
                        <div class="list-border message-list">
                            <li class="media list">
                                <a href="/users/${data.messages[i].user_id}">
                                    ${user_profile_image}
                                </a>                                
                                <div class="media-body">              
                                <a href="/users/${data.messages[i].user_id}" class="message-position d-inline-block">${data.messages[i].user_name}</a>
                                    <p class="message-word-break">
                                        ${data.messages[i].content}
                                    </p>
                                    <div class="message-time-float d-inline-block message-color">
                                        ${created_atFormat}
                                    </div>
                                </div>
                            </li>
                        </div>
                    `;
                    console.log(html);
                    $('.message-data').append(html);
                }
            }
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
    setTimeout("get_data()", 5000);
}

$(function() {
    post_data();
});

function post_data() {
    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
    });
    $('#ajaxPost').on('click', (e) => {
        e.preventDefault();

        const user_id = $('#ajaxPost').data('user_id');
        const post_id = $('#ajaxPost').data('post_id');
        const user_name = $('#ajaxPost').data('user_name');
        const user_profile_image = $('#ajaxPost').data('user_profile_image');
        const content = $('#messageContent').val();

        $('#messageContent').val("");

        console.log(user_id);
        console.log(post_id);
        console.log(user_name);
        console.log(user_profile_image);
        console.log(content);

        $.ajax({
            type: 'POST',
            url: "/result/ajax/" + post_id + "message/store",
            data: {
                user_id: user_id,
                post_id: post_id,
                user_name: user_name,
                user_profile_image: user_profile_image,
                content: content,
            },
            success: () => {
                console.log('成功');
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