<body>
<?=$sidebar?>
<div id="vi_container" class="container">
    <div id="shade"></div>
    <div id="sbtn" class="sbtn">
        <div class="icon sidebtn">
        </div>
    </div>
    <div class="content">
        <div class="container-head">
            <h1>消息中心</h1>
            <div id="vi_menu" class="vi-menu width-100p">
                <ul>
                    <li>
                        <a href="<?=base_url().'notification';?>" class="link">全部</a>
                    </li>
                    <li>
                        <a href="<?=base_url().'notification/conversation'?>" class="link">私信</a>
                    </li>
                    <li class="active">
                        <a href="<?=base_url().'notification/comment'?>" class="link">评论</a>
                    </li>
                    <li>
                        <a href="<?=base_url().'notification/like'?>" class="link">赞</a>
                    </li>
                </ul>
            </div>
            <div id="comment_list" class="conversation">
                <div class="message-item">
                    <div class="message-row">
                        <div class="avatar av-icon">
                            <img src="<?=base_url().'public/img/icon/info_icon_com.png'?>" /></div>
                        <time class="timeago" title="2015-07-29 01:07:10" datetime="2015-07-29 01:07:10" style="float:right;"></time>
                        <h3>谁谁 评论了你的文章</h3>
                        <p id="comment"></p>
                    </div>
                </div>
            </div>
        </div>
        <?=$footer?>
    </div>
</div>
</body>
<script>
    $(function(){
        var BASE_URL = $("#BASE_URL").val();
        var COMMENT_URL = BASE_URL + 'notification/main/get_notification_list';
        var page = 0;

        $.ajax({
            type: "POST",
            url: COMMENT_URL,
            data: {
                type: 'comment',
                page: page,
            },
            success: function(data) {
                alert(data);
                // var obj = eval('(' + data + ')');

                // for( i in obj ) {
                //     var item = obj[i];
                //     var content = eval('(' + item.content + ')');
                //     $('#comment_list').append('<div class="message-item"><div class="message-row"><div class="avatar av-icon"><img src="'+ item.sender.pic +'" /></div><time class="timeago" title="'+ content.publish_time +'" datetime="' + content.publish_time + '" style="float:right;"></time><h3>'+item.sender.name+' 评论了你的文章 '+ content.content_title +'</h3><p id="comment">'+content.comment_content+'</p></div></div>');
                // }
            }
        });

        $(".timeago").timeago();
    });
</script>
</html>