<!-- 私信列表的界面 -->
<body>
<?=$sidebar?>
<div id="vi_container" class="container">
    <div id="shade"></div>
    <div class="content">
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
                        <a href="<?=base_url().'notification/comment'?>" class="link">评论</a>
                    </li>
                    <li>
                        <a href="<?=base_url().'notification/like'?>" class="link">赞</a>
                    </li>
                </ul>
            </div>
            <div id="conversation_list" class="conversation"></div>
        </div>
        <?=$footer?>
    </div>
</div>
</body>
<script>
    var notification = Array();
    function insert_message(nid,img, conversation_url, name, content,count) {
        var read_flag = notification[nid].read_flag;
        var time = notification[nid].publish_time;
        if(read_flag == 0)
        {
            $("#conversation_list").append('<a class="link" href="'+conversation_url+'"><div class="message-item" type="1" nid="'+nid+'"><div class="message-row"><div class="avatar av-icon"><img src="' + img + '" /></div><h3>'+name+'</h3><p>'+content+'（<time class="timeago" title="'+ time +'" datetime="'+time +'+08:00"></time>）</p><p>新消息: '+count+'</p></div></div></a>');            
        }
        else
        {
            $("#conversation_list").append('<a class="link" href="'+conversation_url+'"><div class="message-item" type="1" nid="'+nid+'"><div class="message-row"><div class="avatar av-icon"><img src="' + img + '" /></div><h3>'+name+'</h3><p>'+content+'（<time class="timeago" title="'+ time +'" datetime="'+time +'+08:00"></time>）</p></div></div></a>');                        
        }    
    }


    $(function(){
               
        var BASE_URL = $("#BASE_URL").val();
        var GET_NOTIFICATION_URL = BASE_URL + "notification/main/get_notification_list";
        var CONVERSATION_URL = BASE_URL + 'conversation/';
        var READ_URL = BASE_URL+'notification/main/read';        
        var page = 0;

        $.ajax({
            type: "POST",
            url: GET_NOTIFICATION_URL,
            data: {
                type: 'conversation',
                page: page,
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
                page += 1;

                for(i in obj) {
                    var item = obj[i];
                    notification[item.id] = Array();
                    notification[item.id] = item;
                    if(item.type == 1) {
                        var data = eval("(" + item.content + ")");
                        var nid =item.id;
                        var content = data.conversation_content;
                        var count=data.count;
                        var cid = data.conversation_id;
                        var img = item.sender.pic;
                        var name= item.sender.name;

                        insert_message(nid, img, CONVERSATION_URL+cid, name, content,count);
                    }
                }

                $(".timeago").timeago();

                $(".message-item").click(function(){
                    var nid = $(this).attr('nid');
                    var type= notification[nid].type;
                    $.ajax({
                        type: "POST",
                        url: READ_URL,
                        data: {
                            nid  : nid,
                            type: type
                        },
                        success:function(data){

                        }
                    });           
                });                 
            }
        });

    });
</script>
</html>