<body>
<div class="main-wrapper">
    <?= $top ?>
    <div class="container">
        <div class="item-list search">

            <h2 class="theme">艺术品</h2>

            <div class="item clearfix">
                <div class="image-warp">
                    <img class="image"
                         src="http://hanzh.oss-cn-shenzhen.aliyuncs.com/public/production/thumb1_1440130089_2.jpg"
                         alt="">
                </div>
                <p class="title">我的世界</p>
                <p class="time">2015-09-08</p>
                <p class="content">
                    Web前端开发:[1]高质量CSS-base.css,前端开发工程师是一个很新的职业,在国内乃至国际上真正受到重视的时间不超过五年。但是随着we2.0概念的普及和W3C组织de推广,...</p>
                <div class="price">23000￥</div>
            </div>

            <h2 class="theme">专题</h2>

            <?php for($i = 0; $i < 5; $i ++) {?>
            <div class="item clearfix">
                <div class="image-warp">
                    <img class="image"
                         src="http://hanzh.oss-cn-shenzhen.aliyuncs.com/public/production/thumb1_1440130089_2.jpg"
                         alt="">
                </div>
                <p class="title">我的世界</p>
                <p class="time">2015-09-08</p>
                <p class="content">
                    Web前端开发:[1]高质量CSS-base.css,前端开发工程师是一个很新的职业,在国内乃至国际上真正受到重视的时间不超过五年。但是随着we2.0概念的普及和W3C组织de推广,...</p>
            </div>
            <?php } ?>

            <h2 class="theme">资讯</h2>

            <div class="item clearfix">
                <p class="empty">没有搜索结果</p>
            </div>

        </div>
    </div>
    <?= $footer ?>
</div>
</body>
</html>