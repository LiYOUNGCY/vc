<body>

<div class="main-wrapper">
    <!-- 顶部 -->
    <?php echo $top; ?>
    <!-- 主体 -->
    <div class="container">
        <div class="personal">
            <div class="ptitle">
                个人中心
            </div>
            <div class="pmenu">
                <ul>
                    <li>
                        <a href="<?= base_url() ?>setting">
                            <div class="icon psetting"></div>
                            <div class="mt">账户设置</div>
                        </a>
                    </li>
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
                </ul>
            </div>
            <div class="psubmenu">
                <div class="active">系统消息</div><div class="dot"></div>
                &nbsp; / &nbsp;
                <div><a href="<?= base_url() ?>msg/goodsmsg">交易消息</a></div><div class="dot"></div>
                &nbsp; / &nbsp;
                <div><a href="<?= base_url() ?>msg/csmsg">客服</a></div>
            </div>
            <div class="msglist">

            </div>
        </div>
    </div>
    <?php echo $footer; ?>
</div>
<script type="text/javascript" src="<?= base_url() ?>public/js/swiper.min.js"></script>
</body>
<script>
    $(function () {
        var page = 0;
        var type = 1;

        function loadMsg(){
            $.ajax({
                type: 'POST',
                url: GET_NOTIFICATION,
                async: false,
                data: {
                    page: page
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
                        '<div class="icon psysmsg"></div><div class="time">'+ time +'</div></div>' +
                        '<div class="content">'+ content +'</div>' +
                        '<div class="opt">' +
                        '<a href="javascript:void(0)" class="link">删除</a>' +
                        '</div></div>';
                        
                        $(".msglist").append(box);
                    }
                }
            });
        }

        loadMsg();

    })

</script>
</html>
