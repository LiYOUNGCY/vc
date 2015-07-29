<body>
    <?php 
    echo $sidebar;
    ?>
    <div id="vi_container" class="container-960">
        <div id="shade"></div>
        <div id="sbtn" class="sbtn">
            <div class="icon sidebtn"></div>
        </div>
        <div class="container-head">
            <h1>消息中心</h1>
            <div id="vi_menu" class="vi-menu width-100p">
                <ul>
                    <li>
                        <a href="<?=base_url().'notification';?>" class="link">全部</a>
                    </li>
                    <li class="active">
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
        </div>
        <div class="conversation">
            <div class="clearfix" style="position:relative;">
                <div id="submit" class="send btn">发送</div>
                <div id="emotion" class="emotion"></div>
                <div class="msg"><textarea id="msg"  placeholder="想说写什么..."></textarea></div>
            </div>

            <div id="message" class="message clearfix">
            </div>

            <div class="loadmore width-100p" style="text-align:center;">
                <div id="loadmore" class="btn load_btn">
                    <font id="text">加载更多</font>
                    <i class="fa fa-spinner fa-pulse" style="text-decoration: none;display:none" id="icon"></i>
                </div>
            </div>
        </div>
    </div>
</body>
	<script>
        function insert_left_msg(img, username, content){
            $("#message").append('<div class="message-box message-left"><div class="message-content"><div class="triangle-left"></div><div class="avatar avatar-left"><img src="'+ img +'"><div class="username">'+ username +'</div></div><p>'+ content +'</p></div></div>');
        }


        function insert_right_msg(img, username, content) {
            $("#message").append('<div class="message-box message-right"><div class="message-content"><div class="triangle-right"></div><div class="avatar avatar-right"><img src="' + img + '"><div class="username">' + username + '</div></div><p>'+ content +'</p></div></div>');
        }

        function insert_time(time) {
            $("#message").append('<div class="time-box">' + time + '</div>')
        }


        function insert_data(obj, last_time) {
            var he = obj.he;
            var me = obj.me;
            

            for(i in obj.list) {
                var item = obj.list[i];

                //创建时间
                var time = item.publish_time.substr(0, 10);
                if(time != last_time) {
                    last_time = time;
                    insert_time(last_time);
                }

                if(me.id == item.sender_id) {
                    insert_right_msg(me.pic, me.name, item.content);
                }
                else if(he.id == item.sender_id ){
                    insert_left_msg(he.pic, he.name, item.content);
                }
            }
        }
		$(function(){
            var BASE_URL = $("#BASE_URL").val();
            var URL = BASE_URL + "conversation/main/get_conversation_content";
            var SEND_URL = BASE_URL + "conversation/main/publish_conversation";

            var uid = -1;
            var last_time = 0;

            var page = 0;
            //获得对话的 id
            var cid = window.location.href.split("/");
            cid = cid[cid.length-1];

			 $('#msg').flexText();
             $('#emotion').qqFace({ 
                assign: 'msg',                          //给输入框赋值 
                path: BASE_URL + "public/img/face/"     //表情图片存放的路径 
            });

            $("#submit").click(function(){ 
                var str = $("#msg").val();

                $.ajax({
                    type: "POST",
                    url: SEND_URL,
                    data: {
                        uid: uid,
                        conversation_content: str
                    },
                    success: function(data) {
                        data = eval('('+data+')');
                        if(data.error != null)
                        {
                            ERROR_OUTPUT(data);
                            return false;
                        }
                        else if(data.success == 0)
                        {
                           //成功处理
                           location.reload();
                        }

                    }
                });
            });


            // ajax 获取数据
            $.ajax({
                type: "POST",
                url: URL,
                data: {
                    page: page,
                    cid: cid
                },
                success: function(data) {
                    var obj = eval("(" + data + ")");
                    //错误
                    if(obj.error != null)
                    {
                        ERROR_OUTPUT(obj);
                        return false;
                    }
                    //没数据
                    else if(obj == null || obj == "")
                    {
                        return false;
                    }
                    uid = obj.he.id;
                    // alert(obj.he.id);
                    insert_data(obj, last_time);
                }
            });
            
            $('#loadmore').click(function(){
                page = page + 1;

                $.ajax({
                    type: "POST",
                    url: URL,
                    data: {
                        page: page,
                        cid: cid
                    },
                    success: function(data) {
                        var obj = eval("(" + data + ")");
                        //错误
                        if(obj.error != null)
                        {
                            ERROR_OUTPUT(obj);
                            return false;
                        }
                        //没数据
                        else if(obj == null || obj == "")
                        {
                            return false;
                        }                        
                        // alert(obj.he.id);
                        insert_data(obj, last_time);
                    }
                });
            });
		});
	</script>
</html>