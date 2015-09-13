<body>

<div class="main-wrapper">
    <!-- 顶部 -->
    <?php echo $top; ?>
    <!-- 主体 -->
    <div class="container">
        <div class="personal">
            <div class="userinfo clearfix">
                <div class="uhead">
                    <img src="<?= $user['pic'] ?>">
                </div>
                <div class="info">
                    <ul>
                        <li><label>昵称</label>：<?= $user['name'] ?></li>
                        <li><label>收货地址</label>：<?php echo 1 ? "空" : $user['address']; ?></li>
                        <li><label>联系电话</label>：<?php echo 1 ? "空" : $user['tel']; ?></li>
                        <li><label>联系人</label>：</li>
                    </ul>
                    <a href="<?= base_url() ?>setting">
                        <div class="editinfo btn">修改信息</div>
                    </a>
                </div>
            </div>
            <div class="ptitle">
                个人中心
            </div>
            <div class="pmenu">
                <ul>
                    <li>
                        <a href="<?= base_url() ?>like">
                            <div class="icon plike"></div>
                            <div class="mt">我的喜欢</div>
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url() ?>transaction">
                            <div class="icon pbuyed"></div>
                            <div class="mt">购买记录</div>
                        </a>
                    </li>
                    <li class="tc">
                        <a href="<?= base_url() ?>cart">
                            <div class="icon pcart"></div>
                            <div class="mt">购物车</div>
                        </a>
                    </li>
                    <li class="active">
                        <a href="javascript:void(0);">
                            <div class="icon pmsg"></div>
                            <div class="mt">信息</div>
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url() ?>setting/safe">
                            <div class="icon psetting"></div>
                            <div class="mt">安全设置</div>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="psubmenu">
                <div><a href="<?= base_url() ?>msg">系统消息</a></div><div class="dot"></div>
                &nbsp; / &nbsp;
                <div class="active">交易消息</div><div class="dot"></div>
                &nbsp; / &nbsp;
                <div><a href="<?= base_url() ?>msg/csmsg">客服</a></div>
            </div>
            <div class="msglist">

            </div>
        </div>
    </div>
    <?php echo $footer; ?>
</div>
<?php
if ($user['role'] == 0) {
    echo $sign;
}
?>
<script type="text/javascript" src="<?= base_url() ?>public/js/swiper.min.js"></script>
</body>
<script>
    $(function () {
        var page = 0;
        var type = 2;

        function loadMsg(){
            $.ajax({
                type: 'POST',
                url: GET_NOTIFICATION,
                async: false,
                data: {
                    page: page,
                    type: type
                },
                dataType: 'json',
                success: function (data) {
                    var items = data;

                    if (items.error != null || items.length === 0) {
                        console.log('Error');
                        return;
                    }
                    
                    page++;

                    for (var i = 0; i < items.length; i++) {
                        var content = items[i].content;
                        var time    = items[i].publish_time;
                        var id      = items[i].id;
                        time = time.substr(0, 10);

                        var box = '' + 
                        '<div class="col clearfix" id="'+ id +'">' +
                        '<div class="type">' +
                        '<div class="icon pshopmsg"></div><div class="time">'+ time +'</div></div>' +
                        '<div class="content">'+ content +'</div>' +
                        '<div class="opt">' +
                        '<a href="javascript:void(0)" class="link" onclick="deletemsg()">删除</a>' +
                        '</div></div>';
                        
                        $(".msglist").append(box);
                    }
                }
            });
        }

        loadMsg();

    })
    function deletemsg(){
        
    }


</script>
</html>
