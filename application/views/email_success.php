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
                    <p>
                        验证成功，将在
                        <span class="light" id="time">3</span>
                        秒内跳转
                    </p>
                </div>
            </div>
        </div>
    </div>
    <?php echo $footer; ?>
</div>
</body>
<script>

    $(function () {
        var waitTime = 3;
        var time = self.setInterval(function () {
                waitTime--;
                $("#time").html(waitTime);
                if (waitTime == 0) {
                    window.clearInterval(time);
                    window.location.href = BASE_URL;
                }
            }
            , 1000);
    })
</script>
</html>
