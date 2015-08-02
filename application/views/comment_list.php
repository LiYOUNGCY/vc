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
                    <li class="active">
                        <a href="<?=base_url().'notification/comment'?>" class="link">评论</a>
                    </li>
                    <li>
                        <a href="<?=base_url().'notification/like'?>" class="link">赞</a>
                    </li>
                </ul>
            </div>
            <div id="comment_list" class="conversation">
            </div>
            <div class="loadmore width-100p" style="margin: 0 auto; text-align:center;">
                <div id="loadmore" class="btn load_btn"> <font id="text">加载更多</font> <i class="fa fa-spinner fa-pulse" style="text-decoration: none;display:none" id="icon"></i>
                </div>
            </div>
        </div>
        <?=$footer?>
    </div>
</div>
</body>
<script>
    var BASE_URL = $("#BASE_URL").val();
    var COMMENT_URL = BASE_URL + 'notification/main/get_notification_list';
    var DELETE_COMMENT_URL = BASE_URL + 'notification/main/delete'

    function del(nid) { 
        $.ajax({
            type: "POST",
            url: DELETE_COMMENT_URL,
            data: {
                type: 2,
                nid: nid
            },
            success: function(data) {
                obj = eval('('+data+')');
                //错误
                if(obj.error != null)
                {
                    ERROR_OUTPUT(obj);
                    return false;
                }
                //成功
                else if(obj.success == 0)
                {
                    $(".message-item[tag='"+nid+"']").fadeOut(200);                
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
                    type: 'comment',
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
                        $('#comment_list').append('<div class="message-item" tag="'+item.id+'" ><div class="message-row"><div class="avatar av-icon"><img src="'+ item.sender.pic +'"></div><div class="delete"><a onclick="del('+item.id+')" class="link" href="javascript:void(0);"><i class="fa fa-close"></i></a></div><h4 class="comment_head">'+item.sender.name+'<span class="timeago"  title="'+item.publish_time+'" datetime="'+item.publish_time+'"></span>评论了你的文章<a class="link" href="'+BASE_URL+'article/'+ content.content_id+'">《'+content.content_title+'》</a></h4><p id="comment">'+content.comment_content+'</p></div></div>');
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