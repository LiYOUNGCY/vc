<body>
<div class="container">
    <a class="link" href="">
        <h3>管理中心</h3>
    </a>》
    <a class="link" href="">
        <h3>客服中心</h3>
    </a>

    <div class="wrap">
        <div class="contacts">
            <div class="list">
            <?php for ($i = 0; $i < 15; $i++) { ?>
                <div class="avatar">
                    <img src="http://hanzh.oss-cn-shenzhen.aliyuncs.com/public/upload/20150911/14419469971106.png"
                         alt="">
                    <div class="name">Miss CC</div>
                </div>
            <?php } ?>
            </div>
        </div>
        <div class="dialog"></div>
    </div>
</div>
</body>
<script>
    $(function () {
        $('.list').perfectScrollbar();
    });
</script>