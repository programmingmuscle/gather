$('.flash_message').fadeOut(5000);

$('.accordion-title').on('click', () => {

    if (!$('.accordion-content').is(':visible')) {
        $('.accordion-content').slideDown();
    } else {
        $('.accordion-content').slideUp();
    }
});

$('#ajaxPost').on('click', (e) => {
    const messageContent = $('#messageContent').val();

    if (messageContent === '') {
        e.preventDefault();

        $('.remove-error-messageContent').remove();

        $('.remove-error-messageContentStr').remove();

        $('<div class="error-target remove-error-messageContent">空のメッセージは送信できません。</div>').insertAfter('#messageContent-error');

    }  else if (messageContent.length > 191) {
        e.preventDefault();

        $('.remove-error-messageContent').remove();

        $('.remove-error-messageContentStr').remove();
        
        $('<div class="error-target remove-error-messageContentStr">メッセージは191文字以内として下さい。</div>').insertAfter('#messageContent-error');

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
    const user_id = $('#ajaxPost').data('user_id');
    const post_id = $('#ajaxGet').data('post_id');
    $.ajax({
        type: 'POST',
        url: "/result/ajax/" + post_id,
        dataType: "json",
    }).done(function(data) {
            $('.message-list').remove();
            for (let i = 0; i < data.messages.length; i++) {
                if ((data.messages[i].user_profile_image != undefined) && data.messages[i].user_id == user_id) {
                    let user_profile_image = `
                        <figure>
                            <img src="/storage/profile_images/${data.messages[i].user_id}.jpg" class="profile_image" alt="ユーザのプロフィール画像です。">
                        </figure>
                    `;
                    let content = data.messages[i].content;
                    let contentReplace = content.replace(/\n/g, "<br>");
                    console.log(content);
                    let created_at = new Date(data.messages[i].created_at);
                    let year = created_at.getFullYear();
                    let month = created_at.getMonth() + 1;                    
                    let date = created_at.getDate();
                    let hour = created_at.getHours();
                    let minute = ("0" + created_at.getMinutes()).slice(-2);
                    let created_atFormat = `${year}/${month}/${date} ${hour}:${minute}`;
                    console.log(created_atFormat);
                    let html = `
                        <div class="list-border message-list" data-messageId="${data.messages[i].id}">
                            <li class="media list">
                                <a href="/users/${data.messages[i].user_id}">
                                    ${user_profile_image}
                                </a>
                                <div class="media-body">              
                                    <a href="/users/${data.messages[i].user_id}" class="message-position d-inline-block">${data.messages[i].user_name}</a>
                                    <p class="message-word-break">
                                        ${contentReplace}
                                    </p>
                                    <div class="message-float">
                                        <div class="text-right">
                                            <span class="message-edit-color">編集</span>|<span class="message-delete-color">削除</span>
                                        </div>
                                        <div class="message-color">
                                            ${created_atFormat}
                                        </div>
                                    </div> 
                                </div>
                            </li>
                        </div>
                    `;
                    console.log(html);
                    if ( data.messages[i].created_at != data.messages[i].updated_at) {
                        html = `
                        <div class="list-border message-list" data-messageId="${data.messages[i].id}">
                            <li class="media list">
                                <a href="/users/${data.messages[i].user_id}">
                                    ${user_profile_image}
                                </a>
                                <div class="media-body">              
                                    <a href="/users/${data.messages[i].user_id}" class="message-position d-inline-block">${data.messages[i].user_name}</a>
                                    <p class="message-word-break">
                                        ${contentReplace}
                                    </p>
                                    <div class="message-float">
                                        <p class="message_content text-right mr-0">編集済み</p>
                                        <div class="text-right">
                                            <span class="message-edit-color">編集</span>|<span class="message-delete-color">削除</span>
                                        </div>
                                        <div class="message-color">
                                            ${created_atFormat}
                                        </div>
                                        
                                    </div> 
                                </div>
                            </li>
                        </div>
                        `;
                    }
                    $('.message-data').append(html);
                } else if ((data.messages[i].user_profile_image != undefined) && data.messages[i].user_id != user_id) {
                    let user_profile_image = `
                        <figure>
                            <img src="/storage/profile_images/${data.messages[i].user_id}.jpg" class="profile_image" alt="ユーザのプロフィール画像です。">
                        </figure>
                    `;
                    let content = data.messages[i].content;
                    let contentReplace = content.replace(/\n/g, "<br>");
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
                                        ${contentReplace}
                                    </p>
                                    <div class="message-float d-inline-block message-color">
                                        ${created_atFormat}
                                    </div>
                                </div>
                            </li>
                        </div>
                    `;
                    console.log(html);
                    if ( data.messages[i].created_at != data.messages[i].updated_at) {
                        html = `
                        <div class="list-border message-list" data-messageId="${data.messages[i].id}">
                            <li class="media list">
                                <a href="/users/${data.messages[i].user_id}">
                                    ${user_profile_image}
                                </a>
                                <div class="media-body">              
                                    <a href="/users/${data.messages[i].user_id}" class="message-position d-inline-block">${data.messages[i].user_name}</a>
                                    <p class="message-word-break">
                                        ${contentReplace}
                                    </p>
                                    <div class="message-float">
                                        <p class="message_content text-right mr-0">編集済み</p>
                                        <div class="message-color">
                                            ${created_atFormat}
                                        </div>
                                    </div> 
                                </div>
                            </li>
                        </div>
                        `;
                    }
                    $('.message-data').append(html);
                } else if ((data.messages[i].user_profile_image == undefined) && data.messages[i].user_id == user_id) {
                    let user_profile_image = `
                        <figure>
                            <img src="/assets/images/noimage.jpeg" class="profile_image" alt="ユーザのプロフィール画像です。">
                        </figure>
                    `;
                    let content = data.messages[i].content;
                    let contentReplace = content.replace(/\n/g, "<br>");
                    let created_at = new Date(data.messages[i].created_at);
                    let year = created_at.getFullYear();
                    let month = created_at.getMonth() + 1;                    
                    let date = created_at.getDate();
                    let hour = created_at.getHours();
                    let minute = ("0" + created_at.getMinutes()).slice(-2);
                    let created_atFormat = `${year}/${month}/${date} ${hour}:${minute}`;
                    console.log(created_atFormat);
                    let html = `
                        <div class="list-border message-list" data-messageId="${data.messages[i].id}">
                            <li class="media list">
                                <a href="/users/${data.messages[i].user_id}">
                                    ${user_profile_image}
                                </a>
                                <div class="media-body">              
                                    <a href="/users/${data.messages[i].user_id}" class="message-position d-inline-block">${data.messages[i].user_name}</a>
                                    <p class="message-word-break">
                                        ${contentReplace}
                                    </p>
                                    <div class="message-float">
                                        <div class="text-right">
                                            <span class="message-edit-color">編集</span>|<span class="message-delete-color">削除</span>
                                        </div>
                                        <div class="message-color">
                                            ${created_atFormat}
                                        </div>
                                    </div> 
                                </div>
                            </li>
                        </div>
                    `;
                    console.log(html);
                    if ( data.messages[i].created_at != data.messages[i].updated_at) {
                        html = `
                        <div class="list-border message-list" data-messageId="${data.messages[i].id}">
                            <li class="media list">
                                <a href="/users/${data.messages[i].user_id}">
                                    ${user_profile_image}
                                </a>
                                <div class="media-body">              
                                    <a href="/users/${data.messages[i].user_id}" class="message-position d-inline-block">${data.messages[i].user_name}</a>
                                    <p class="message-word-break">
                                        ${contentReplace}
                                    </p>
                                    <div class="message-float">
                                        <p class="message_content text-right mr-0">編集済み</p>
                                        <div class="text-right">
                                            <span class="message-edit-color">編集</span>|<span class="message-delete-color">削除</span>
                                        </div>
                                        <div class="message-color">
                                            ${created_atFormat}
                                        </div>
                                    </div> 
                                </div>
                            </li>
                        </div>
                        `;
                    }
                    $('.message-data').append(html);
                } else {
                    let user_profile_image = `
                        <figure>
                            <img src="/assets/images/noimage.jpeg" class="profile_image" alt="ユーザのプロフィール画像です。">
                        </figure>
                        `;
                        let content = data.messages[i].content;
                        let contentReplace = content.replace(/\n/g, "<br>");
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
                                        ${contentReplace}
                                    </p>
                                    <div class="message-float d-inline-block message-color">
                                        ${created_atFormat}
                                    </div>
                                </div>
                            </li>
                        </div>
                    `;
                    console.log(html);
                    if ( data.messages[i].created_at != data.messages[i].updated_at) {
                        html = `
                        <div class="list-border message-list" data-messageId="${data.messages[i].id}">
                            <li class="media list">
                                <a href="/users/${data.messages[i].user_id}">
                                    ${user_profile_image}
                                </a>
                                <div class="media-body">              
                                    <a href="/users/${data.messages[i].user_id}" class="message-position d-inline-block">${data.messages[i].user_name}</a>
                                    <p class="message-word-break">
                                        ${contentReplace}
                                    </p>
                                    <div class="message-float">
                                        <p class="message_content text-right mr-0">編集済み</p>
                                        <div class="message-color">
                                            ${created_atFormat}
                                        </div>  
                                    </div> 
                                </div>
                            </li>
                        </div>
                        `;
                    }
                    $('.message-data').append(html);
                }
            }
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

}


$(function() {
    load_data();
});

function load_data() {
    setInterval("get_data()", 5000);
}

$(function() {
    post_data();
});

function post_data() {
    let canAjax = true;

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
    });
    
    $('#ajaxPost').on('click', (e) => {
        e.preventDefault();

        if (!canAjax) {
            return;
        }
        canAjax = false;

        const user_id = $('#ajaxPost').data('user_id');
        const post_id = $('#ajaxPost').data('post_id');
        const user_name = $('#ajaxPost').data('user_name');
        const user_profile_image = $('#ajaxPost').data('user_profile_image');
        const content = $('#messageContent').val();

        $.ajax({
            type: 'POST',
            url: "/result/ajax/" + post_id + "/store",
            data: {
                'user_id': user_id,
                'post_id': post_id,
                'user_name': user_name,
                'user_profile_image': user_profile_image,
                'content': content,
            },
        }).done(function() {
                console.log(user_id);
                console.log(post_id);
                console.log(user_name);
                console.log(user_profile_image);
                console.log(content);
                $('#messageContent').val("");
                $('#messageZero').remove();
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

$(document).on('click', '.message-edit-color', (e) => {
    let messageId = $(e.currentTarget).parent().parent().parent().parent().parent().attr('data-messageId');
    let content = $(e.currentTarget).parent().parent().parent().find('p.message-word-break').html();
    let trimContent = content.trim();
    let contentReplace = trimContent.replace(/<br>/g, "\n");
    console.log(trimContent);
    console.log(contentReplace);
   
    let form = `
        <div class="modal" tabindex="-1" role="dialog" id="updateModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">メッセージ編集</h5>
                        <button type="button" class="close updateModalClose" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="message-form w-auto">        
                            <div class="messageUpdate-box">
                                <div id="messageContentEdit-error"></div>   
                                <textarea name="content" id="messageContentEdit" class="form-control" placeholder="メッセージを送信して連絡を取り合いましょう！">${contentReplace}</textarea>
                            </div>    
                            <div class="message-button">
                                <input type="submit" value="完了" id="ajaxUpdate" data-messageId="${messageId}" class="btn btn-success">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    `;
    console.log(form);
    $('.show_content').before(form);
    $('#updateModal').fadeIn();
    
});

$(document).on('click', '.updateModalClose', ()=> {
    $('#updateModal').remove();
});

$(document).on('click', '#ajaxUpdate', (e) => {
    const messageContentEdit = $('#messageContentEdit').val();

    if (messageContentEdit === '') {
        e.preventDefault();

        $('#remove-error-content').remove();

        $('.remove-error-messageContentEdit').remove();

        $('.remove-error-messageContentEditStr').remove();

        $('<p class="error-message alert alert-danger list-unstyled" id="remove-error-content" role="alert">入力に問題があります。再入力して下さい。</p>').prependTo('#content');
        
        $('<div class="error-target remove-error-messageContentEdit">空のメッセージは送信できません。</div>').insertAfter('#messageContentEdit-error');

    }  else if (messageContentEdit.length > 191) {
        e.preventDefault();

        $('#remove-error-content').remove();

        $('.remove-error-messageContentEdit').remove();

        $('.remove-error-messageContentEditStr').remove();

        $('<p class="error-message alert alert-danger list-unstyled" id="remove-error-content" role="alert">入力に問題があります。再入力して下さい。</p>').prependTo('#content');
        
        $('<div class="error-target remove-error-messageContentEditStr">メッセージは191文字以内として下さい。</div>').insertAfter('#messageContentEdit-error');

    } else {
        $('#remove-error-content').remove();

        $('.remove-error-messageContentEdit').remove();

        $('.remove-error-messageContentEditStr').remove();
    }
});

$(function() {
    update_data();
});

function update_data() {
    let canAjax = true;

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
    });
    
    $(document).on('click', '#ajaxUpdate', (e) => {
        e.preventDefault();

        if (!canAjax) {
            return;
        }
        canAjax = false;

        const user_id = $('#ajaxPost').data('user_id');
        const post_id = $('#ajaxPost').data('post_id');
        const user_name = $('#ajaxPost').data('user_name');
        const user_profile_image = $('#ajaxPost').data('user_profile_image');
        const content = $('#messageContentEdit').val();

        const messageId = $('#ajaxUpdate').attr('data-messageId');
        console.log(messageId);

        $.ajax({
            type: 'POST',
            url: "/result/ajax/" + messageId + "/update",
            data: {
                'user_id': user_id,
                'post_id': post_id,
                'user_name': user_name,
                'user_profile_image': user_profile_image,
                'content': content,
            },
        }).done(function() {
            console.log(content);
                $('#messageContentEdit').val("");
                $('#remove-error-content').remove();
                $('#updateModal').remove();
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
    delete_data();
});

function delete_data() {
    let canAjax = true;

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
    });
    
    $(document).on('click', '.message-delete-color', (e) => {
        e.preventDefault();

        if (!canAjax) {
            return;
        }
        canAjax = false;

        let messageId = $(e.currentTarget).parent().parent().parent().parent().parent().attr('data-messageId');
        console.log(messageId);

        $.ajax({
            type: 'POST',
            url: "/result/ajax/" + messageId + "/destroy",
        }).done(function() {
                get_data();
        }).fail(function(jqXHR, textStatus, errorThrown) {
                alert("データの取得に失敗しました。");
                console.log("ajax通信に失敗しました");
                console.log("jqXHR          : " + jqXHR.status);
                console.log("textStatus     : " + textStatus);
                console.log("errorThrown    : " + errorThrown.message);
                console.log("URL            : " + url);
        }).always(function(){
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
        }).fail(function() {
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