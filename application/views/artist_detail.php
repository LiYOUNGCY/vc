<body>
<div class="main-wrapper">
    <!-- 顶部 -->
    <?php echo $top; ?>
    <!-- 主体 -->
    <div class="container">
        <div class="artist_detail">
            <div class="pic"><img src="<?= $artist['pic'] ?>"></div>
            <div class="detail">
                <div class="name"><?= $artist['name'] ?></div>
                <div class="intro">
                    <p><?= $artist['intro'] ?></p>

                    <div class="more"><a href="" class="link">[阅读更多+]</a></div>
                </div>
            </div>
        </div>
        <div class="artistevaluate">
            <div class="title">维C推荐</div>
            <div class="detail">
                <p><?= $artist['evaluation'] ?></p>
            </div>
        </div>
        <div class="artlist">
            <div class="item">
                <div class="pic"></div>
                <div class="info">
                    <div class="name"></div>
                    <div class="pop"></div>
                </div>
            </div>
            <div class="item"></div>
            <div class="item"></div>
        </div>


        <?php echo $footer; ?>
    </div>
</div>

<?php echo $sign; ?>

</body>

<script>
    $(function () {

    });
</script>
</html>
