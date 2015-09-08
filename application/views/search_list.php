<body>
<div class="main-wrapper">
    <?= $top ?>
    <div class="container">
        <div class="item-list search">


            <h2 class="theme">艺术品</h2>
            <?php if (empty($query['production'])) { ?>
                <div class="item clearfix">
                    <p class="empty">没有搜索结果</p>
                </div>
            <?php } else { ?>
                <?php foreach ($query['production'] as $key => $value) { ?>
                    <div class="item clearfix">
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
                <?php }
            } ?>


            <h2 class="theme">专题和资讯</h2>
            <?php if (empty($query['article'])) { ?>
                <div class="item clearfix">
                    <p class="empty">没有搜索结果</p>
                </div>
            <?php } else { ?>
                <?php foreach ($query['article'] as $key => $value) { ?>
                    <div class="item clearfix">
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
                <?php }
            } ?>


            <h2 class="theme">艺术家</h2>
            <?php if (empty($query['artist'])) { ?>
                <div class="item clearfix">
                    <p class="empty">没有搜索结果</p>
                </div>
            <?php } else { ?>
                <?php foreach ($query['artist'] as $key => $value) { ?>
                    <div class="item clearfix">
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
                <?php }
            } ?>

        </div>
    </div>
    <?= $footer ?>
</div>
</body>
</html>