<body>

<div class="main-wrapper">
    <!-- 顶部 -->
    <?php echo $top; ?>
    
    <!-- 轮播 -->
    <div class="swiper-container" id="swiper">
        <div class="swiper-wrapper">
            <?php foreach ($slider as $k => $v): ?>
                <div class="swiper-slide">
                    <a href="<?= $v['href'] ?>">
                    <img data-src="<?= $v['pic'] ?>" class="swiper-lazy">
                    <div class="swiper-shadow" ></div>
                    <div class="swiper-lazy-preloader"></div>
                    </a>
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
            <div class="title">最专业的艺术品导购平台</div>
            <div class="subtitle">The most professional art shopping guide platform</div>
        </div>
        <!-- 最新专题 -->
        <div class="new-subject">
            <div class="list" id="subject-list">
                <div id="stamp" class="wrapper clearfix">
                    <div class="hd clearfix">
                        <div class="title">
                            最新专题
                            <div class="tran"></div>
                        </div>
                    </div>
                    <div class="more"><a href="<?= base_url() ?>topic" class="link">more</a></div>
                </div>
                <?php $i = 0;
                foreach ($topic as $k => $v): ?>
                    
                    <?php
                        if ($i > 3) {
                            break;
                        }
                        if ($i == 0) {
                            $i = 1;
                            echo '<div class="item big"><a href="'.base_url().'article/'.$v['content']['article_id'].'"><div class="box" style="background:url('.$v['content']['article_bigimage'].');background-size:cover;background-position:50% 50%;">';
                        } else {
                            echo '<div class="item"><a href="'.base_url().'article/'.$v['content']['article_id'].'"><div class="box" style="background: url('.$v['content']['article_image'].');background-size:cover;background-position:50% 50%;">';
                        }
                        ++$i;
                    ?>
                            <div class="info">
                                <p><?=$v['content']['article_content']?></p>
                            </div>
                            <div class="intro">
                                <div class="name">（<font color="#FFFFFF"><?=$v['content']['sort_title']?></font>）</div>
                                <div class="collect"><?=$v['like']?><div class="icon like"></div></div>
                            </div>
                        </div>
                        </a>
                    </div>
                <?php endforeach;?>
            </div>
        </div>

        <!-- 最新上架 -->
        <div class="new-art">

            <div class="list" id="art-list">
                <div class="wrapper clearfix">
                    <div class="hd clearfix">
                        <div class="title">
                            最新作品
                            <div class="tran"></div>
                        </div>
                    </div>
                    <div class="more"><a href="<?= base_url() ?>topic" class="link">more</a></div>
                </div>
                <?php $i = 0;
                foreach ($production as $k => $v): ?>
                    <?php

                        if ($i == 0) {
                            echo '<div class="item big"><a href="'.base_url().'production/'.$v['id'].'"><div class="box" style="background:url('.$v['bigpic'].');background-size:cover;background-position:50% 50%;">';
                        } else {
                            echo '<div class="item"><a href="'.base_url().'production/'.$v['id'].'"><div class="box" style="background: url('.$v['pic'].');background-size:cover;background-position:50% 50%;">';
                        }
                        ++$i;
                    ?>
                            <div class="info">
                                <div class="look">
                                    <div class="icon search"></div>
                                </div>
                                <div class="artistpic">
                                    <img src="<?=$v['artist']['pic'];?>">
                                </div>
                            </div>
                            <div class="intro">
                                <div class="name">（<font color="#FFFFFF"><?=$v['name']?></font>）</div>
                                <div class="collect"><?=$v['like']?><div class="icon like"></div></div>
                            </div>
                        </div>
                        <div class="price icon pricebg">￥<?=$v['price']?></div>
                        </a>
                    </div>
                <?php endforeach;?>
            </div>
        </div>
        <div class="other">

            <div class="item">
                <div class="title">
                    <div class="icon oweic"></div>
                    关于艺术维C
                </div>
                <div class="content">
                    <p>
                        艺术维C是致力于促进艺术市场良性发展而打造的，国内首家专业艺术品导购平台。艺术维C以网络模式为发展动力，以电子商务模式运营C从而推动艺术市场的发展及完善，为国内外艺术品爱好者提供优质的青年艺术家原创艺术品及最专业的艺术品导购服务。
                    </p>
                </div>
            </div>
            <div class="item mid">
                <div class="title">
                    <div class="icon oseleted"></div>
                    精心挑选
                </div>
                <div class="content">
                    <p>
                        艺术维C所有作品，均由专业人士精心挑选，兼具收藏价值与观赏价值。合作艺术家均为专业艺术院校、艺术专业出身，受过正规训练兼举办过展览的青年艺术家。我们旨在为您提供真诚、放心、全面的优质服务。
                    </p>
                </div>
            </div>
            <div class="item">
                <div class="title">
                    <div class="icon osafe"></div>
                    我们承诺
                </div>
                <div class="content">
                    <p>
                        为消费者导购优秀青年艺术家的原创当代艺术品，为所有艺术爱好者提供一个“放心、安心、舒心”的网上购物环境是艺术维C的运营目标，艺术维C向您郑重承诺，所有在平台内出售的作品均为艺术家原创作品，均由作者本人、作品拥有者或者其亲自指定的代理人提供发布，权威保真，所有作品均统一出具《艺术维C收藏证书》。
                    </p>
                </div>
            </div>
            
        </div>
    </div>
    <?=$footer?>
</div>
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
        
    });
    var swiper = new Swiper('.artist-swiper', {
        autoplayDisableOnInteraction: false,
        speed: 500,
        prevButton: '.swiper-button-prev',
        nextButton: '.swiper-button-next'
    });

    $(function () {
        var subject = document.querySelector('#subject-list');
        var art = document.querySelector('#art-list');
        var swiper_w = $("#swiper").width();
        var swiper_h = $(window).width() > 960 ? swiper_w*0.3 : swiper_w*0.47;


        $("#swiper").height(swiper_h);

        var masonry = new Masonry(subject, {
            itemSelector: '.item',
            stamp: '.wrapper',
            columnWidth: 300,
            gutter: 30,
            isFitWidth: true,
            isAnimate: true
        });
        var masonry2 = new Masonry(art, {
            itemSelector: '.item',
            stamp: '.wrapper',
            columnWidth: 300,
            gutter: 30,
            isFitWidth: true,
            isAnimate: true,
            noSwiping: true
        });
    })

</script>
</html>
