<body>

<div class="main-wrapper">
    <?php echo $top;?>
    <div class="container">
        <div class="margin-top">

            <?php for($i = 0; $i < 8; $i++) { ?>
            <div class="production">
                <div >
                    <img class="image" src="<?=base_url()?>public/img/load.gif" data-src="http://hanzh.oss-cn-shenzhen.aliyuncs.com/public/production/1439471082_5.jpg" alt="">
                </div>
                <div class="wrap">
                    <div class="title">作品标题</div>
                    <div class="author"><span>作者：</span><span>鸡巴白</span></div>
                    <div class="price">售价：<span>450</span></div>
                    <div class="footer clearfix">
                        <div class="btn">赞</div>
                        <div class="btn">作品详情</div>
                    </div>
                </div>
            </div>
            <?php } ?>

        </div>
    </div>
</div>

<script>
    $(function() {
        var page = 0;
        'use strict';

        var $container = $('.margin-top');
        var container = document.querySelector('.margin-top');
        var page = 0;

        var masonry = new Masonry(container, {
            itemSelector: '.production',
            columnWidth: 302,
            gutter: 25,
            isFitWidth: true,
            isAnimate: true
        });

        $container.imageloader({
            selector: '.image',
            each: function (elm) {
                console.log("load done");
                console.log(elm.width + " " + elm.height);
                $(elm).parent().css({'height':elm.height, 'width':elm.width});
                masonry.layout();
            }
        });

        $.ajax({
            type: 'post',
            url: GET_PRODUCTION_URL,
            data: {
                page: page
            }
            dataType: 'json',
            success: function(data) {

            }
        });

        function LoadMore() {
            $.ajax({
                type: 'POST',
                url: GET_PRODUCTION_URL,
                data: {
                    page: page
                },
                dataType: 'json',
                success: function(data) {
                    // var items = eval('(' + data + ')');
                    var items = data;

                    if(items.error != null || items.length === 0) {
                        console.log('Error');
                        return ;
                    }

                    page ++;

                    for(var i = 0; i < items.length; i++) {
                        // var items[i].content = items[i].content;

                        var article_id = items[i].content.article_id;
                        var article_title = items[i].content.sort_title;
                        var article_content = items[i].content.article_content;
                        var img = items[i].content.article_image;
                        var like = items[i].like;
                        var read = items[i].read;


                        var box = $('<div class="production"> <div > <img class="image" src="<?=base_url()?>public/img/load.gif" data-src="'+img+'" alt=""> </div> <div class="wrap"> <div class="title">'+title+'</div> <div class="author"><span>作者：</span><span>'+author+'</span></div> <div class="price">售价：<span>'+price+'</span></div> <div class="footer clearfix"> <div class="btn">赞</div> <div class="btn">作品详情</div> </div> </div> </div>');
                        $container.append(box);
                        masonry.appended(box);

                        $(box).imageloader({
                            each: function(elm){
                                masonry.layout();
                                console.log(elm.width + " " + elm.height);
                                $(elm).parent().css({'height':elm.height, 'width':elm.width});
                            },
                            callback: function (elm) {
                                console.log('loadding');
                                masonry.layout();
                            }
                        });

                        $('#img_load_'+ page).scrollLoading();
                        //Add Event
                        WindowEvent();

                        // -------------- End -------------
                    }
                }
            });
        }
    });
</script>