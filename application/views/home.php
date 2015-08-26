<body>

<div class="main-wrapper">
    <!-- 顶部 -->
    <?php echo $top;?>
    <!-- 主体 -->
    <div class="container">
    <!-- 轮播 -->
    <div class="swiper-container">
        <div class="swiper-wrapper">
            <?php foreach ($slider as $k => $v):?>
                <div class="swiper-slide">
                    <img data-src="<?=$v['pic']?>" class="swiper-lazy">
                    <div class="swiper-lazy-preloader swiper-lazy-preloader-white"></div>
                </div>                                     
            <?php endforeach;?>
        </div>
        <!-- 轮播位置 -->
        <div class="swiper-pagination swiper-pagination-white"></div>
    </div>
    <!-- 最新专题 -->
    <div class="new-subject">
        <div class="wrapper clearfix">
            <div class="title">最新专题</div>
            <div class="more"><a href="<?=base_url()?>topic" class="link">more</a></div>
        </div>
        <div class="list" id="subject-list">
            <?php foreach ($topic as $k => $v):?>

                <div class="item">
                    <div class="sub-image" style="background: url(<?=$v['content']['article_image']?>);background-size:cover;background-position:50% 50%;"></div>
                    <div class="sub-title"><?=$v['content']['sort_title']?></div>
                    <div class="sub-content"><?=$v['content']['article_content']?></div>
                    <ul class="sub-info">
                        <li><i class="fa fa-heart-o"></i><?=$v['like']?></li>
                        <li><i class="fa fa-eye"></i><?=$v['read']?></li>
                    </ul>
                </div>                
            <?php endforeach;?>
        </div>
    </div>
    <!-- 最新上架 -->
    <div class="new-art">
        <div class="wrapper clearfix">
            <div class="title">最新上架</div>
            <div class="more"><a href="<?=base_url()?>production" class="link">more</a></div>
        </div>
        <div class="list" id="art-list">
            <?php foreach ($production as $k => $v):?>
                <div class="item">
                    <figure class="effect-bubba">
                        <div class="art-image" style="background: url(<?=$v['pic']?>);background-size:cover;background-position:50% 50%;"></div>
                        <figcaption>
                            <p>类型：<?=$v['type_name']?><br>尺寸：<?=$v['l']?> * <?=$v['h']?> cm</p>
                        </figcaption>           
                    </figure>
                    <div class="art-title"><?=$v['name']?></div>
                    <div class="author">作者：<?=$v['artist']['name']?></div>
                    <ul class="art-info">
                        <li><i class="fa fa-heart-o"></i> <?=$v['like']?></li>
                        <!--<li><i class="fa fa-eye"></i></li>-->
                        <div class="price"><?=$v['price']?>RMB</div>
                    </ul>
                </div>                
            <?php endforeach;?>           
        </div>
    </div>
    <div class="advbanner">ADV</div>
    <!-- 作者 -->
    <div class="new-artist">
        <div class="title">最新艺术家</div>
        <div class="artist-swiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide new-artlist-list swiper-no-swiping">
                    <ul>
                        <li>
                            <div class="head">
                                <img src="http://hanzh.oss-cn-shenzhen.aliyuncs.com/public/upload/20150814/14395425281750.jpg">
                            </div>
                            <div class="name">鸡巴白</div>
                        </li>
                        <li>
                            <div class="head">
                                <img src="http://hanzh.oss-cn-shenzhen.aliyuncs.com/public/upload/20150814/14395425281750.jpg">
                            </div>
                            <div class="name">鸡巴白</div>
                        </li>
                        <li>
                            <div class="head">
                                <img src="http://hanzh.oss-cn-shenzhen.aliyuncs.com/public/upload/20150814/14395425281750.jpg">
                            </div>
                            <div class="name">鸡巴白</div>
                        </li>
                        <li>
                            <div class="head">
                                <img src="http://hanzh.oss-cn-shenzhen.aliyuncs.com/public/upload/20150814/14395425281750.jpg">
                            </div>
                            <div class="name">鸡巴白</div>
                        </li>
                        <li>
                            <div class="head">
                                <img src="http://hanzh.oss-cn-shenzhen.aliyuncs.com/public/upload/20150814/14395425281750.jpg">
                            </div>
                            <div class="name">鸡巴白</div>
                        </li>
                    </ul>
                </div>
                <div class="swiper-slide new-artlist-list swiper-no-swiping">
                    <ul>
                        <li>
                            <div class="head">
                                <img src="http://hanzh.oss-cn-shenzhen.aliyuncs.com/public/upload/20150814/14395425281750.jpg">
                            </div>
                            <div class="name">鸡巴白</div>
                        </li>
                        <li>
                            <div class="head">
                                <img src="http://hanzh.oss-cn-shenzhen.aliyuncs.com/public/upload/20150814/14395425281750.jpg">
                            </div>
                            <div class="name">鸡巴白</div>
                        </li>
                        <li>
                            <div class="head">
                                <img src="http://hanzh.oss-cn-shenzhen.aliyuncs.com/public/upload/20150814/14395425281750.jpg">
                            </div>
                            <div class="name">鸡巴白</div>
                        </li>
                        <li>
                            <div class="head">
                                <img src="http://hanzh.oss-cn-shenzhen.aliyuncs.com/public/upload/20150814/14395425281750.jpg">
                            </div>
                            <div class="name">鸡巴白</div>
                        </li>
                        <li>
                            <div class="head">
                                <img src="http://hanzh.oss-cn-shenzhen.aliyuncs.com/public/upload/20150814/14395425281750.jpg">
                            </div>
                            <div class="name">鸡巴白</div>
                        </li>
                    </ul>
                </div>
                <div class="swiper-slide new-artlist-list swiper-no-swiping">
                    <ul>
                        <li>
                            <div class="head">
                                <img src="http://hanzh.oss-cn-shenzhen.aliyuncs.com/public/upload/20150814/14395425281750.jpg">
                            </div>
                            <div class="name">鸡巴白</div>
                        </li>
                        <li>
                            <div class="head">
                                <img src="http://hanzh.oss-cn-shenzhen.aliyuncs.com/public/upload/20150814/14395425281750.jpg">
                            </div>
                            <div class="name">鸡巴白</div>
                        </li>
                        <li>
                            <div class="head">
                                <img src="http://hanzh.oss-cn-shenzhen.aliyuncs.com/public/upload/20150814/14395425281750.jpg">
                            </div>
                            <div class="name">鸡巴白</div>
                        </li>
                        <li>
                            <div class="head">
                                <img src="http://hanzh.oss-cn-shenzhen.aliyuncs.com/public/upload/20150814/14395425281750.jpg">
                            </div>
                            <div class="name">鸡巴白</div>
                        </li>
                        <li>
                            <div class="head">
                                <img src="http://hanzh.oss-cn-shenzhen.aliyuncs.com/public/upload/20150814/14395425281750.jpg">
                            </div>
                            <div class="name">鸡巴白</div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>
    </div>
    <?php echo $footer;?>
    </div> 
</div>
<?php echo $sign;?>   
<script type="text/javascript" src="<?=base_url()?>public/js/swiper.min.js"></script>
</body>
<script>

var swiper = new Swiper('.swiper-container', {
    pagination: '.swiper-pagination',
    paginationClickable: true,
    preloadImages: true,
    lazyLoading: true,
    loop: true,
    autoplay : 5000,
    autoplayDisableOnInteraction : false,
    speed: 500,
    grabCursor: true
});
var swiper = new Swiper('.artist-swiper', {
    autoplayDisableOnInteraction : false,
    speed: 500,
    prevButton:'.swiper-button-prev',
    nextButton:'.swiper-button-next',
});

$(function(){
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
        noSwiping : true
    });
})

</script>
</html>
