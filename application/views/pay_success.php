<body>

<div class="main-wrapper">
    <!-- 顶部 -->
    <?php echo $top; ?>
    <!-- 主体 -->
    <div class="container">
        <div class="callbackbox">
            <div class="icon logo-normal"></div>
            <div class="econtent">
                <div class="icon tick"></div>
                <div class="success">
                    <p>支付成功！您可以 <a class="link" href="<?=base_url()?>transaction">查看购买记录</a></p>
                </div>
            </div>
        </div>
    </div>
    <?php echo $footer; ?>
</div>
</body>
<script>
//
//    $(function () {
//        var waitTime = 3;
//        var time = self.setInterval(function () {
//                waitTime--;
//                $("#time").html(waitTime);
//                if (waitTime == 0) {
//                    window.clearInterval(time);
//                    window.location.href = BASE_URL;
//                }
//            }
//            , 1000);
//    })
</script>
</html>
