<!-- 显示全部消息的界面 -->
<body>
<?=$sidebar?>
<div id="vi_container" class="container">
    <div id="shade"></div>
    <div id="sbtn" class="sbtn">
        <div class="icon">
            <div class="sidebtn"></div>
        </div>
    </div>
    <div class="content">
        <div class="container-head">
            <h1>消息中心</h1>
            <div id="vi_menu" class="vi-menu width-100p">
                <ul>
                    <li class="active">
                        <a href="<?=base_url().'notification';?>" class="link">全部</a>
                    </li>
                    <li>
                        <a href="<?=base_url().'notification/conversation'?>" class="link">私信</a>
                    </li>
                    <li>
                        <a href="#" class="link">评论</a>
                    </li>
                    <li>
                        <a href="#" class="link">赞</a>
                    </li>
                </ul>
            </div>
            <div id="messgae" class="conversation">

                <div class="message-item">
                    <div class="message-row">
                        <div class="avatar av-icon">
                            <img src="<?=base_url().'public/img/icon/info_icon_com.png'?>" /></div>
                        <h3>评论</h3>
                        <p id="comment"></p>
                    </div>
                </div>
                <div class="message-item">
                    <div class="message-row">
                        <div class="avatar av-icon">
                            <img src="<?=base_url().'public/img/icon/info_icon_dum.png'?>" /></div>
                        <h3>赞</h3>
                        <p id="like"></p>
                    </div>
                </div>
                <div class="message-item">
                    <div class="message-row">
                        <div class="avatar av-icon">
                            <img src="<?=base_url().'public/img/icon/info_icon_follow.png'?>" /></div>
                        <h3>关注</h3>
                        <p id="follower"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<script>
    function insert_message(img, conversation_url, name, content) {
        $("#messgae").append('<a class="link" href="'+conversation_url+'"><div class="message-item"><div class="message-row"><div class="avatar av-icon"><img src="' + img + '" /></div><h3>'+name+'</h3><p>'+content+'</p></div></div></a>');
    }

    $(function (){
        var BASE_URL = $("#BASE_URL").val();
        var GET_NOTIFICATION_URL = BASE_URL + "notification/main/get_notification_list";
        var CONVERSATION_URL = BASE_URL + 'conversation/';
        var page = 0;


        $.ajax({
            type: "POST",
            url: GET_NOTIFICATION_URL,
            data: {
                type: 'all',
                page: page,
            },
            success: function(data) {
                var obj = eval("(" + data + ")");
                page += 1;

                for(i in obj) {
                    var item = obj[i];

                    if(item.type == 1) {
                        var data = eval("(" + item.content + ")");

                        var content = data.conversation_content;
                        var cid = data.conversation_id;
                        var img = item.sender.pic;
                        var name= item.sender.name;

                        insert_message(img, CONVERSATION_URL+cid, name, content);
                    }
                    else if(item.type == 2) {
                        $("#comment").html(item.count);
                    }
                    else if(item.type == 3) {
                        $("#like").html("您被" + item.count + "人点赞");
                    }
                    else if(item.type == 4) {
                        $("#follower").html("您被" + item.count + "人关注");
                    }
                }
            }
        });

    });
</script>
</html>