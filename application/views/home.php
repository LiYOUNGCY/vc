<body>

<div class="main-wrapper">
    <!-- 顶部 -->
    <?php echo $top; ?>
    
    <!-- 轮播 -->
    <div class="swiper-container" id="swiper">
        <div class="swiper-wrapper">
            <?php foreach ($slider as $k => $v): ?>
                <div class="swiper-slide">
                    <img data-src="<?= $v['pic'] ?>" class="swiper-lazy">
                    <div class="swiper-shadow" ></div>
                    <div class="swiper-lazy-preloader"></div>
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
                <?php $i=0;
                foreach ($topic as $k => $v): ?>
                    <?php
                        if($i == 0)
                        {
                            $i=1;
                            echo '<div class="item big"><div class="box" style="background:url('.$v['content']['article_bigimage'].');background-size:cover;background-position:50% 50%;">';
                        }
                        else
                        {
                            echo '<div class="item"><div class="box" style="background: url('.$v['content']['article_image'].');background-size:cover;background-position:50% 50%;">';
                        }
                    ?>
                            <div class="info">
                                <p><?=$v['content']['article_content']?></p>
                            </div>
                            <div class="intro">
                                <div class="name">（<font color="#FFFFFF"><?=$v['content']['sort_title']?></font>）</div>
                                <div class="collect"><?=$v['like']?><div class="icon like"></div></div>
                            </div>
                        </div>
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
                <?php $i=0;
                foreach ($production as $k => $v): ?>
                    <?php
                        if($i > 3) {
                            break;
                        }
                        if($i == 0)
                        {
                            echo '<div class="item big"><div class="box" style="background:url('.$v['bigpic'].');background-size:cover;background-position:50% 50%;">';
                        }
                        else
                        {
                            echo '<div class="item"><div class="box" style="background: url('.$v['pic'].');background-size:cover;background-position:50% 50%;">';
                        }
                        $i++;
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
                    </div>
                <?php endforeach;?>
            </div>
        </div>
        <div class="other">
            <div class="item">
                <div class="title">
                    <div class="icon oseleted"></div>
                    精心挑选
                </div>
                <div class="content">
                    <p>
                        使用阿里多媒体云服务，您可以坐享阿里领先的海量存储集群、国内海外多节点部署的CDN网络、强大的转码、渲染、图片处理服务等。共享淘宝天猫一样专业及响应迅速的技术保障和运维能力。同时阿里云资深架构师和官方认证的上云服务提供商也为您提供专业的架构咨询和服务。
                    </p>
                </div>
            </div>
            <div class="item mid">
                <div class="title">
                    <div class="icon osafe"></div>
                    我们承诺
                </div>
                <div class="content">
                    <p>
                        使用阿里多媒体云服务，您可以坐享阿里领先的海量存储集群、国内海外多节点部署的CDN网络、强大的转码、渲染、图片处理服务等。共享淘宝天猫一样专业及响应迅速的技术保障和运维能力。同时阿里云资深架构师和官方认证的上云服务提供商也为您提供专业的架构咨询和服务。
                    </p>
                </div>
            </div>
            <div class="item">
                <div class="title">
                    <div class="icon osure"></div>
                    我们的目标
                </div>
                <div class="content">
                    <p>
                        使用阿里多媒体云服务，您可以坐享阿里领先的海量存储集群、国内海外多节点部署的CDN网络、强大的转码、渲染、图片处理服务等。共享淘宝天猫一样专业及响应迅速的技术保障和运维能力。同时阿里云资深架构师和官方认证的上云服务提供商也为您提供专业的架构咨询和服务。
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
        nextButton: '.swiper-button-next',
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
