<body>

<div class="main-wrapper">
    <!-- 顶部 -->
    <?php echo $top; ?>
    <!-- 轮播 -->
    <div class="swiper-container">
        <div class="swiper-wrapper">
            <?php foreach ($slider as $k => $v): ?>
                <div class="swiper-slide">
                    <img data-src="<?= $v['pic'] ?>" class="swiper-lazy">

                    <div class="swiper-lazy-preloader swiper-lazy-preloader-white"></div>
                </div>
            <?php endforeach; ?>
        </div>
        <!-- 轮播位置 -->
        <div class="swiper-pagination swiper-pagination-white"></div>
    </div>

    <!-- 主体 -->
    <div class="container">
        <!-- 导语 -->
        <div class="vcinfo">
            <div class="icon info"></div>
        </div>
        <!-- 最新专题 -->
        <div class="new-subject">
            <div class="wrapper clearfix">
                <div class="hd clearfix">
                    <div class="title">最新专题</div>
                    <div class="tran"></div>
                </div>
                <div class="more"><a href="<?= base_url() ?>topic" class="link">more</a></div>
            </div>
            <div class="list" id="subject-list">

                <div class="item big">
                    <div class="box" style="background: url(http://hanzh.oss-cn-shenzhen.aliyuncs.com/public/slider/1440004716_1.jpg);background-size:cover;background-position:50% 50%;">
                        <div class="info">
                            <p>撒旦打发第三方士大夫士大夫水电三方士大夫士大夫水电费三方士大夫士大夫水电费三方士大夫士大夫水电费费水电费费水...</p>
                        </div>
                        <div class="intro">
                            <div class="name">（<font color="#FFFFFF">开学啦!补考啦!</font>）</div>
                            <div class="collect">123<div class="icon like"></div></div>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="box" style="background: url(http://hanzh.oss-cn-shenzhen.aliyuncs.com/public/slider/1440004716_1.jpg);background-size:cover;background-position:50% 50%;">
                        <div class="info">
                            <p>撒旦打发第三方士大夫士大夫水电三方士大夫士大夫水电费三方士大夫士大夫水电费三方士大夫士大夫水电费费水电费费水...</p>
                        </div>
                        <div class="intro">
                            <div class="name">（<font color="#FFFFFF">开学啦!补考啦!</font>）</div>
                            <div class="collect">123<div class="icon like"></div></div>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="box" style="background: url(http://hanzh.oss-cn-shenzhen.aliyuncs.com/public/slider/1440004716_1.jpg);background-size:cover;background-position:50% 50%;">
                        <div class="info">
                            <p>撒旦打发第三方士大夫士大夫水电三方士大夫士大夫水电费三方士大夫士大夫水电费三方士大夫士大夫水电费费水电费费水...</p>
                        </div>
                        <div class="intro">
                            <div class="name">（<font color="#FFFFFF">开学啦!补考啦!</font>）</div>
                            <div class="collect">123<div class="icon like"></div></div>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="box" style="background: url(http://hanzh.oss-cn-shenzhen.aliyuncs.com/public/slider/1440004716_1.jpg);background-size:cover;background-position:50% 50%;">
                        <div class="info">
                            <p>撒旦打发第三方士大夫士大夫水电三方士大夫士大夫水电费三方士大夫士大夫水电费三方士大夫士大夫水电费费水电费费水...</p>
                        </div>
                        <div class="intro">
                            <div class="name">（<font color="#FFFFFF">开学啦!补考啦!</font>）</div>
                            <div class="collect">123<div class="icon like"></div></div>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="box" style="background: url(http://hanzh.oss-cn-shenzhen.aliyuncs.com/public/slider/1440004716_1.jpg);background-size:cover;background-position:50% 50%;">
                        <div class="info">
                            <p>撒旦打发第三方士大夫士大夫水电三方士大夫士大夫水电费三方士大夫士大夫水电费三方士大夫士大夫水电费费水电费费水...</p>
                        </div>
                        <div class="intro">
                            <div class="name">（<font color="#FFFFFF">开学啦!补考啦!</font>）</div>
                            <div class="collect">123<div class="icon like"></div></div>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="box" style="background: url(http://hanzh.oss-cn-shenzhen.aliyuncs.com/public/slider/1440004716_1.jpg);background-size:cover;background-position:50% 50%;">
                        <div class="info">
                            <p>撒旦打发第三方士大夫士大夫水电三方士大夫士大夫水电费三方士大夫士大夫水电费三方士大夫士大夫水电费费水电费费水...</p>
                        </div>
                        <div class="intro">
                            <div class="name">（<font color="#FFFFFF">开学啦!补考啦!</font>）</div>
                            <div class="collect">123<div class="icon like"></div></div>
                        </div>
                    </div>
                </div>
                    <!-- <div class="item">
                        <div class="sub-image"
                             style="background: url(<?= $v['content']['article_image'] ?>);background-size:cover;background-position:50% 50%;"></div>
                        <div class="sub-title"><?= $v['content']['sort_title'] ?></div>
                        <div class="sub-content"><?= $v['content']['article_content'] ?></div>
                        <ul class="sub-info">
                            <li><i class="fa fa-heart-o"></i><?= $v['like'] ?></li>
                            <li><i class="fa fa-eye"></i><?= $v['read'] ?></li>
                        </ul>
                    </div> -->
            </div>
        </div>

        <!-- 最新上架 -->
        <div class="new-art">
            <div class="wrapper clearfix">
                <div class="hd clearfix">
                    <div class="title">最新作品</div>
                    <div class="tran"></div>
                </div>
                <div class="more"><a href="<?= base_url() ?>topic" class="link">more</a></div>
            </div>
            <div class="list" id="art-list">
                <div class="item big">
                    <div class="box" style="background: url(http://hanzh.oss-cn-shenzhen.aliyuncs.com/public/slider/1440004716_1.jpg);background-size:cover;background-position:50% 50%;">
                        <div class="info">
                            <p>撒旦打发第三方士大夫士大夫水电三方士大夫士大夫水电费三方士大夫士大夫水电费三方士大夫士大夫水电费费水电费费水...</p>
                        </div>
                        <div class="intro">
                            <div class="name">（<font color="#FFFFFF">开学啦!补考啦!</font>）</div>
                            <div class="collect">123<div class="icon like"></div></div>
                        </div>
                    </div>
                    <div class="price icon pricebg">￥2000</div>
                </div>
                <div class="item">
                    <div class="box" style="background: url(http://hanzh.oss-cn-shenzhen.aliyuncs.com/public/slider/1440004716_1.jpg);background-size:cover;background-position:50% 50%;">
                        <div class="info">
                            <p>撒旦打发第三方士大夫士大夫水电三方士大夫士大夫水电费三方士大夫士大夫水电费三方士大夫士大夫水电费费水电费费水...</p>
                        </div>
                        <div class="intro">
                            <div class="name">（<font color="#FFFFFF">开学啦!补考啦!</font>）</div>
                            <div class="collect">123<div class="icon like"></div></div>
                        </div>
                    </div>
                    <div class="price icon pricebg">￥2000</div>
                </div>
                <div class="item">
                    <div class="box" style="background: url(http://hanzh.oss-cn-shenzhen.aliyuncs.com/public/slider/1440004716_1.jpg);background-size:cover;background-position:50% 50%;">
                        <div class="info">
                            <p>撒旦打发第三方士大夫士大夫水电三方士大夫士大夫水电费三方士大夫士大夫水电费三方士大夫士大夫水电费费水电费费水...</p>
                        </div>
                        <div class="intro">
                            <div class="name">（<font color="#FFFFFF">开学啦!补考啦!</font>）</div>
                            <div class="collect">123<div class="icon like"></div></div>
                        </div>
                    </div>
                </div>  
                <div class="item">
                    <div class="box" style="background: url(http://hanzh.oss-cn-shenzhen.aliyuncs.com/public/slider/1440004716_1.jpg);background-size:cover;background-position:50% 50%;">
                        <div class="info">
                            <p>撒旦打发第三方士大夫士大夫水电三方士大夫士大夫水电费三方士大夫士大夫水电费三方士大夫士大夫水电费费水电费费水...</p>
                        </div>
                        <div class="intro">
                            <div class="name">（<font color="#FFFFFF">开学啦!补考啦!</font>）</div>
                            <div class="collect">123<div class="icon like"></div></div>
                        </div>
                    </div>
                </div>  


                    <!-- <div class="item">
                        <figure class="effect-bubba">
                            <div class="art-image"
                                 style="background: url(<?= $v['pic'] ?>);background-size:cover;background-position:50% 50%;"></div>
                            <figcaption>
                                <p>类型：<?= $v['type_name'] ?><br>尺寸：<?= $v['l'] ?> * <?= $v['h'] ?>cm</p>
                            </figcaption>
                        </figure>
                        <div class="art-title"><?= $v['name'] ?></div>
                        <div class="author">作者：<?= $v['artist']['name'] ?></div>
                        <div class="art-info clearfix">
                            <div class="vote"><i class="fa fa-heart-o"></i> <?= $v['like'] ?></div>
                            <div class="price"><?= $v['price'] ?>RMB</div>
                        </div>
                    </div> -->

            </div>
        </div>
        


        
    </div>
    <?php echo $footer; ?>
</div>
<?php echo $sign; ?>
<script type="text/javascript" src="<?= base_url() ?>public/js/swiper.min.js"></script>
</body>
<script>

    var swiper = new Swiper('.swiper-container', {
        pagination: '.swiper-pagination',
        paginationClickable: true,
        preloadImages: true,
        lazyLoading: true,
        loop: true,
        autoplay: 5000,
        autoplayDisableOnInteraction: false,
        speed: 500,
        grabCursor: true
    });
    var swiper = new Swiper('.artist-swiper', {
        autoplayDisableOnInteraction: false,
        speed: 500,
        prevButton: '.swiper-button-prev',
        nextButton: '.swiper-button-next',
    });

    $(function () {
        var subject = document.querySelector('#subject-list');
        var art = document.querySelector('#art-list');
        var masonry = new Masonry(subject, {
            itemSelector: '.item',
            columnWidth: 300,
            gutter: 30,
            isFitWidth: true,
            isAnimate: true
        });
        var masonry = new Masonry(art, {
            itemSelector: '.item',
            columnWidth: 300,
            gutter: 30,
            isFitWidth: true,
            isAnimate: true,
            noSwiping: true
        });
    })

</script>
</html>
