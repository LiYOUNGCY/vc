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
                    <li>
                        <a href="<?=base_url().'notification/conversation'?>" class="link">私信</a>
                    </li>
                    <li>
                        <a href="<?=base_url().'notification/comment'?>" class="link">评论</a>
                    </li>
                    <li class="active">
                        <a href="<?=base_url().'notification/like'?>" class="link">赞</a>
                    </li>
                </ul>
            </div>
            <div id="like_list" class="conversation">
            </div>
            <div class="loadmore width-100p" style="margin: 0 auto; text-align:center;">
                <div id="loadmore" class="btn load_btn"> <font id="text">加载更多</font> <i class="fa fa-spinner fa-pulse" style="text-decoration: none;display:none" id="icon"></i>
                </div>
            </div>
        </div>
        <?=$footer?></div>
</div>
</body>
<script>
    var BASE_URL = $("#BASE_URL").val();
    var COMMENT_URL = BASE_URL + 'notification/main/get_notification_list';
    var DELETE_COMMENT_URL = BASE_URL + 'notification/main/delete'

    function del(nid, obj) { 
        $.ajax({
            type: "POST",
            url: DELETE_COMMENT_URL,
            data: {
                type: 3,
                nid: nid
            },
            success: function(data) {
                data = eval('('+data+')');
                if(data.error != null)
                {
                    ERROR_OUTPUT(data);
                    return false;                    
                }
                //成功
                else if(data.success == 0)
                {
                    $(obj).parent().parent().parent().fadeOut(200);
                }

            }
        });
    }

    $(function(){
        
        var page = 0;

        function load_comment() {
            $.ajax({
                type: "POST",
                url: COMMENT_URL,
                data: {
                    type: 'like',
                    page: page,
                },
                success: function(data) {
                    page = page + 1;
                    var obj = eval('(' + data + ')');
                    //错误
                    if(obj.error != null)
                    {
                        ERROR_OUTPUT(obj);
                        return false;
                    }
                    //没数据
                    else if(obj == null || obj == "")
                    {
                        $("#loadmore").unbind();
                        return false;
                    }
                    for( i in obj ) {

                        var item = obj[i];
                        var content = eval('(' + item.content + ')');

                        $('#like_list').append('<div class="message-item"><div class="message-row"><div class="avatar av-icon"><img src="'+ item.sender.pic +'"></div><div class="delete"><div onclick="del('+item.id+', this)" > <i class="fa fa-close" title="删除信息"></i></div></div><h4 class="comment_head">'+item.sender.name+' <span class="timeago" title="'+item.publish_time+'" datetime="'+item.publish_time+'+8:00"></span>赞同了您的文章<a class="link" href="'+BASE_URL+'article/'+ content.content_id+'">《'+content.content_title+'》</a></h4></div></div>');
                    }

                    $(".timeago").timeago();
                }
            });
        }

        load_comment();

        
        $('#loadmore').click(function(){
            load_comment();
        });

        
    });
</script>
</html>