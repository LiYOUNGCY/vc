<body>
<div class="main-wrapper">
    <?= $top ?>
    <div class="container">
        <div class="item-list search">

            <?php foreach ($queue as $key => $value) {
                ?>
                <!-- 专题和资讯 -->
                <?php if ($value == 'article') {
                    ?>
                    <h2 class="theme">专题和资讯</h2>
                    <?php if (empty($query['article'])) {
                        ?>
                        <div class="item clearfix">
                            <p class="empty">没有搜索结果</p>
                        </div>
                        <?php
                    } else {
                        ?>
                        <?php foreach ($query['article'] as $key => $value) {
                            ?>
                            <div class="item clearfix" onclick="article(<?= $value['id'] ?>)">
                                <div class="image-warp">
                                    <img class="image"
                                         src="<?= $query['article'][$key]['content']['article_image'] ?>"
                                         alt="">
                                </div>
                                <p class="title"><?= $query['article'][$key]['content']['article_title'] ?></p>

                                <p class="time"><?= $query['article'][$key]['publish_time'] ?></p>

                                <p class="content">
                                    <?= $query['article'][$key]['content']['article_content'] ?>
                                </p>
                            </div>
                            <?php
                        }
                    }
                    ?>
                    <?php
                }
                ?>
                <!--  END 专题和资讯    -->

                <!-- 艺术品-->
                <?php if ($value == 'production') {
                    ?>
                    <h2 class="theme">艺术品</h2>
                    <?php if (empty($query['production'])) {
                        ?>
                        <div class="item clearfix">
                            <p class="empty">没有搜索结果</p>
                        </div>
                        <?php
                    } else {
                        ?>
                        <?php foreach ($query['production'] as $key => $value) {
                            ?>
                            <div class="item clearfix" onclick="production(<?=$value['id']?>)">
                                <div class="image-warp">
                                    <img class="image"
                                         src="<?= $value['pic'] ?>"
                                         alt="">
                                </div>
                                <p class="title"><?= $value['name'] ?></p>

                                <p class="time"><?= $value['publish_time'] ?></p>

                                <p class="content">
                                    <?= $value['intro'] ?>
                                </p>

                                <div class="price"><?= $value['price'] ?>￥</div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                    <?php
                }
                ?>
                <!-- END 艺术品    -->

                <?php if ($value == 'artist') {
                    ?>
                    <h2 class="theme">艺术家</h2>
                    <?php if (empty($query['artist'])) {
                        ?>
                        <div class="item clearfix">
                            <p class="empty">没有搜索结果</p>
                        </div>
                        <?php
                    } else {
                        ?>
                        <?php foreach ($query['artist'] as $key => $value) {
                            ?>
                            <div class="item clearfix" onclick="artist(<?=$value['id']?>)">
                                <div class="image-warp">
                                    <img class="image"
                                         src="<?= $value['pic'] ?>"
                                         alt="">
                                </div>
                                <p class="title"><?= $value['name'] ?></p>

                                <p class="time"><?= $value['creat_time'] ?></p>

                                <p class="content">
                                    <?= $value['intro'] ?>
                                </p>
                            </div>
                            <?php
                        }
                    }
                    ?>
                    <?php
                }
                ?>

                <?php
            } ?>
        </div>
    </div>
    <?= $footer ?>
</div>
</body>
<script>
    function article(id) {
        if (!isNaN(id))
            window.location.href = BASE_URL + 'article/' + id;
    }

    function artist(id) {
        if (!isNaN(id))
            window.location.href = BASE_URL + 'artist/' + id;
    }

    function production(id) {
        if (!isNaN(id))
            window.location.href = BASE_URL + 'production/' + id;
    }

    $(function () {

        function decode(s) {
            return s.replace(/\\([\\\.\*\[\]\(\)\$\^])/g, "$1").replace(/>/g, ">").replace(/</g, "<").replace(/&/g, "&");
        }

        function encode(s) {
            return s.replace(/&/g, "&").replace(/</g, "<").replace(/>/g, ">").replace(/([\\\.\*\[\]\(\)\$\^])/g, "\\$1");
        }

        function heightLight(keyword) {
            $('.title').each(function (i, value) {
                // var keyword = '的2';
                var str = value.innerHTML;
                var reg = new RegExp(keyword, 'gi');
                var result = str.replace(reg, '<span class="heightlight">' + keyword + '</span>');
                $(this).html(result);
            });
        }

        var keyword = getQueryString('keyword');
        if (typeof keyword != 'undefined' && keyword != null) {
            keyword = decodeURIComponent(keyword);
            console.log(keyword);
            heightLight(keyword);
        }
    });
</script>
</html>
