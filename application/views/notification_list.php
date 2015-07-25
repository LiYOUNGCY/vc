<!-- 显示全部消息的界面 -->
<body>
    <div class="container-960">
        <div class="container-head">
            <h1>消息中心</h1>
            <div id="vi_menu" class="vi-menu width-100p">
                <ul>
                    <li class="active">
                        <a href="#" class="link">全部</a>
                    </li>
                    <li>
                        <a href="#" class="link">私信</a>
                    </li>
                    <li>
                        <a href="#" class="link">评论</a>
                    </li>
                    <li>
                        <a href="#" class="link">赞</a>
                    </li>
                </ul>
            </div>
            <div class="conversation">

                <div class="message-item">
                    <div class="message-row">
                        <div class="avatar av-icon">
                            <img src="<?=base_url().'public/img/icon/info_icon_com.png'?>" />
                        </div>
                        <h3>评论</h3>
                        <p>您收到了Jack、小然May1989、Rongyun、等20位用户的评论</p>
                    </div>
                </div>
                <div class="message-item">
                    <div class="message-row">
                        <div class="avatar av-icon">
                            <img src="<?=base_url().'public/img/icon/info_icon_dum.png'?>" />
                        </div>
                        <h3>赞</h3>
                    </div>
                </div>
                <div class="message-item">
                    <div class="message-row">
                        <div class="avatar av-icon">
                            <img src="<?=base_url().'public/img/icon/info_icon_follow.png'?>" />
                        </div>
                        <h3>关注</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
function insert_data(obj){
    for(var i in obj)
    {
        switch(obj[i].type)
        {
            case '1':
            alert('conversation');
            break;
            case '2':
            alert('comment');
            break;
            case '3':
            alert('like');
            break;
            case '4':
            alert('follow');
            break;                                    
        }
    }
}
function insert_like()
{

}
function insert_comment()
{

}
function insert_conversation()
{

}
function insert_follow()
{

}
$(function(){
    var BASE_URL = $("#BASE_URL").val();
    var URL = BASE_URL + "notification/main/get_notification_list";
    var page = 0;
    //获得消息类型
    var type = window.location.href.split("/");
    type = type[type.length-1];

    $.ajax({
        type: "POST",
        url: URL,
        data: {
            page: page,
            type: type
        },
        success: function(data) {
            var obj = eval("(" + data + ")");
            insert_data(obj);
        }        
    });
});
</script>
</html>