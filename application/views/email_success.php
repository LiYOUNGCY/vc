<body>

<div class="main-wrapper">
    <!-- 顶部 -->
    <?php echo $top; ?>
    <!-- 主体 -->
    <div class="container">
        <div class="emailbox">
            <div class="icon logo-normal"></div>
            <div class="econtent">
                <div class="icon emailconfirm"></div>
                <div class="success">
                    <p>已将验证邮件发送至 <?=$email?></p>
                        <p>没收到邮件怎么办？</p>
                        <p>1. 尝试到垃圾邮件或垃圾箱、广告邮件中找找</p>
                        <p>2. 或再发一遍邮件 点击发送</p>
                        <p>3. 如果依然无法没收到邮件，请您更换其他的邮件地址 <a href="<?=base_url()?>home?callback=login">重新注册</a></p>

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
