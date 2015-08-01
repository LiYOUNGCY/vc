<!-- 显示全部消息的界面 -->
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
                    <li class="active">
                        <a href="<?=base_url().'notification';?>" class="link">全部</a>
                    </li>
                    <li>
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
            <div id="messgae" class="conversation">
            </div>
            
            <div class="message-item" id="comment" style="display:none;">
                <div class="message-row">
                    <div class="avatar av-icon">
                        <img src="<?=base_url().'public/img/icon/info_icon_com.png'?>" /></div>
                    <h3>评论</h3>
                    <p id="comment_count"></p>
                </div>
            </div>
           
            <div class="message-item"  id="like" style="display:none;">
                <div class="message-row">
                    <div class="avatar av-icon">
                        <img src="<?=base_url().'public/img/icon/info_icon_dum.png'?>" /></div>
                    <h3>赞</h3>
                    <p id="like_count"></p>
                </div>
            </div>

            <div class="message-item" id="follower" style="display:none;">
                <div class="message-row">
                    <div class="avatar av-icon">
                        <img src="<?=base_url().'public/img/icon/info_icon_follow.png'?>" /></div>
                    <h3>关注</h3>
                    <p id="follower_count"></p>
                </div>
            </div>
         
        </div>
        <?=$footer?>
    </div>
</div>
</body>
<script>
    var notification = Array();
    function insert_message(nid, img, conversation_url, name, content,count) {
        var read_flag = notification[nid].read_flag;
        var time = notification[nid].publish_time;
        if(read_flag == 0)
        {
            $("#messgae").append('<a class="link" href="'+conversation_url+'"><div class="message-item" type="1" nid="'+nid+'"><div class="message-row"><div class="avatar av-icon"><img src="' + img + '" /></div><h3>'+name+'</h3><p>'+content+'（<time class="timeago" title="'+ time +'" datetime="'+time +'+08:00"></time>）</p><p>新消息: '+count+'</p></div></div></a>');            
        }
        else
        {
            $("#messgae").append('<a class="link" href="'+conversation_url+'"><div class="message-item" type="1" nid="'+nid+'"><div class="message-row"><div class="avatar av-icon"><img src="' + img + '" /></div><h3>'+name+'</h3><p>'+content+'（<time class="timeago" title="'+ time +'" datetime="'+time +'+08:00"></time>）</p></div></div></a>');                        
        }
    }

    $(function (){
        var BASE_URL = $("#BASE_URL").val();
        var GET_NOTIFICATION_URL = BASE_URL + "notification/main/get_notification_list";
        var CONVERSATION_URL = BASE_URL + 'conversation/';
        var READ_URL = BASE_URL+'notification/main/read';
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
                //错误
                if(obj.error != null)
                {
                    ERROR_OUTPUT(obj);
                    return false;
                }
                //没数据
                else if(obj == null || obj == "")
                {
                    page = null;
                    return false;
                }
                page += 1;
                for(i in obj) {
                    var item = obj[i];
                    notification[item.id] = Array();
                    notification[item.id] = item;
                    if(item.type == 1) {
                        var data = eval("(" + item.content + ")");
                        var nid = item.id;
                        var content = data.conversation_content;  
                        var count=data.count;              
                        var cid = data.conversation_id;
                        var img = item.sender.pic;
                        var name= item.sender.name;
                        insert_message(nid,img,CONVERSATION_URL+cid, name, content,count);
                    }
                    else if(item.type == 2) {
                        if(item.read_flag == 0)
                        {
                            $("#comment_count").html("您新收到"+item.count+"条评论"+'（<time class="timeago" title="'+ item.publish_time +'" datetime="'+ item.publish_time +'+08:00"></time>）'); 
                        }  
                        $("#messgae").append($("#comment").clone().css('display','block').attr('nid',item.id));
                    }
                    else if(item.type == 3) {
                        if(item.read_flag == 0)
                        {
                            $("#like_count").html("您被" + item.count + "人点赞"+'（<time class="timeago" title="'+ item.publish_time +'" datetime="'+ item.publish_time +'+08:00"></time>）'); 
                        }   
                        $("#messgae").append($("#like").clone().css('display','block').attr('nid',item.id));                        
                    }
                    else if(item.type == 4) {
                        if(item.read_flag == 0)
                        {
                            $("#follower_count").html("您被" + item.count + "人关注"+'（<time class="timeago" title="'+ item.publish_time +'" datetime="'+ item.publish_time +'+08:00"></time>）'); 
                        }   
                        $("#messgae").append($("#follower").clone().css('display','block').attr('nid',item.id));                        
                    }
                }
                $(".timeago").timeago();

                $(".message-item").click(function(){
                    var nid = $(this).attr('nid');
                    var type= notification[nid].type;
                    if(notification[nid].read_flag == 0)
                    {
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
                    }
                    if(type == 2)
                    {
                        window.location.href = BASE_URL+'notification/comment';
                    }
                    else if(type == 3)
                    {
                        window.location.href = BASE_URL+'notification/like';
                    }
                    else if(type == 4)
                    {
                        window.location.href = BASE_URL+'contacts';
                    }
                }); 


            }
        });

    });
</script>
</html>