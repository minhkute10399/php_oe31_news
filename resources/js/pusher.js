$.ajax({
    type : "GET",
    url : "current-user",
    success : function (e) {
        let id = e.id;
        Echo.private('comment-channel' +id)
            .listen('CommentNotification', (e) => {
                toastr.success(e.channel['title'], e.channel['content']);
                let html = `<a class="dropdown-item" href=${e.channel['post_id']}>
                    <span>Commented</span><br>
                    <small>Someone has been comment on your post</small>
                </a>`;
        $('.notification').append(html);
        });
    }
});
