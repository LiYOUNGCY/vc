<body>
<div class="main-wrapper">
    <?php echo $top; ?>
    <div class="container">

        <div class="item-list" id="item-list">
            <!--标签-->
            <div id="stamp" class="filter-warp">
                <div class="filter">
                    <ul>
                        <li class="label">送礼：</li>
                        <li class="<?php if($w1 == 0) echo 'active'; ?>" data-id="0" data-type="w1">
                            全部
                        </li>

                        <?php foreach ($tag['who'] as $key => $value) { ?>
                            <li class="<?php if($w1 == $value['id']) echo 'active'; ?>" data-id="<?=$value['id']?>" data-type="w1">
                                <?= $value['name'] ?>
                            </li>
                        <?php } ?>
                    </ul>
                    <ul>
                        <li class="label">装修：</li>
                        <li class="<?php if($w2 == 0) echo 'active'; ?>" data-id="0" data-type="w2">
                            全部
                        </li>
                        <?php foreach ($tag['where'] as $key => $value) { ?>
                            <li class="<?php if($w2 == $value['id']) echo 'active'; ?>" data-id="<?=$value['id']?>" data-type="w2">
                                <?= $value['name'] ?>
                            </li>
                        <?php } ?>
                    </ul>
                    <ul>
                        <li class="label">收藏：</li>
                        <li class="<?php if($w3 == 0) echo 'active'; ?>" data-id="0" data-type="w3">
                            全部
                        </li>
                        <?php foreach ($tag['when'] as $key => $value) { ?>
                            <li class="<?php if($w3 == $value['id']) echo 'active'; ?>" data-id="<?=$value['id']?>" data-type="w3">
                                <?= $value['name'] ?>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>


            <!--                <div class="box">-->
            <!--                    <img class="image" src="http://img02.liwushuo.com/image/150409/gu40pimlg.jpg-w720" alt=""/>-->
            <!--                    <p class="title">标题：我的世界</p>-->
            <!--                    <p class="content">-->
            <!--                        这是一段介绍因为爱爱爱爱爱爱爱爱啊啊这是一段介绍因为爱爱爱爱爱爱爱爱啊啊这是一段介绍因为爱爱爱爱爱爱爱啊啊这是一段介绍因为爱爱爱爱爱爱爱爱啊啊dasfdasfdasfdasfdasfdasfdasfssfffffffffffffdsafdasfdasfdasfdasfdasfdasfdasf-->
            <!--                    </p>-->
            <!--                    <div class="bottom clearfix">-->
            <!--                        <div class="like" style="float: right;">-->
            <!--                            <span>199</span>-->
            <!--                            <div class="icon like"></div>-->
            <!--                        </div>-->
            <!--                    </div>-->
            <!--                </div>-->

        </div>
    </div>
    <?php echo $footer; ?>
</div>
</body>
<script>


    function readArticle(id) {
        window.location.href = BASE_URL + 'article/' + id;
    }

    function getTopicListBYtag() {
        $(this).parent().children('.active').removeClass('active');

        var str = $(this).attr('data-type') + '=' +$(this).attr('data-id');

        $('#stamp').find('.active').each(function(){
            var w = $(this).attr('data-type') + '=' + $(this).attr('data-id');
            str += ('&&' + w);
        });

        window.location.href = BASE_URL +'topic?'+str;
    }

    $(function () {
        'use strict';

        var w1 = getQueryString('w1');
        var w2 = getQueryString('w2');
        var w3 = getQueryString('w3');

        w1 = w1 == null ? 0 : w1;
        w2 = w2 == null ? 0 : w2;
        w3 = w3 == null ? 0 : w3;

        var url = GET_TOPIC_URL + '?w1=' + w1 + '&&w2=' + w2 + '&&w3=' + w3;


        var $container = $('.item-list');
        var container = document.querySelector('.item-list');
        var page = 0;

        var masonry = new Masonry(container, {
            itemSelector: '.box',
            stamp: '.filter-warp',
            columnWidth: 300,
            gutter: 30,
            isFitWidth: true,
            isAnimate: false
        });

        $container.imageloader({
            selector: '.image',
            each: function (elm) {
                masonry.layout();
            }
        });


        $('#stamp').find('li').each(function(){
            $(this).click(getTopicListBYtag);
        });

        var count = 0;
        var sum = 0;

        function LoadMore() {
            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    page: page,
                    type: 'topic'
                },
                dataType: 'json',
                success: function (items) {
                    if(items == null) {
                        console.log('[DEBUG]: items is null');
                        return;
                    }

                    if (items.error != null || items.length === 0) {
                        console.log('Error');
                        return;
                    }

                    sum = items.length;
                    page++;

                    for (var i = 0; i < items.length; i++) {

                        var article_id = items[i].content.article_id;
                        var article_title = items[i].content.sort_title;
                        var article_content = items[i].content.article_content;
                        var img = items[i].content.article_image;
                        var like = items[i].like;
                        var read = items[i].read;


                        var box = $('<div class="box" onclick="readArticle(' + article_id + ')" style="height:360px;">' +
                            '<div class="image" style="background-image:url(' + img + ')"></div>' +
                            '<p class="title">' + article_title + '</p>' +
                            '<p class="content">' + article_content + '</p>' +
                            '<div class="bottom clearfix">' +
                            '<div class="like" style="float: right;">' +
                            '<span>' + like + '</span>' +
                            '<div class="icon like"></div>' +
                            '</div>' +
                            '</div>' +
                            '</div>');
                        $container.append(box);
                        masonry.appended(box);

                        $(box).imageloader({
                            each: function (elm) {
                                masonry.layout();
                                count++;
                                if (count == sum) {
                                    //Add Event
                                    WindowEvent();
                                    count = 0;
                                }
                            }
                        });
                        // -------------- End -------------
                    }
                }
            });
        }

        LoadMore();

//        $(document).click(function () {
//            console.log('click');
//            LoadMore();
//        });

        WindowEvent();


        function WindowEvent() {
            $(window).scroll(function () {
                // 当滚动到最底部以上100像素时， 加载新内容
                if ($(document).height() - $(this).scrollTop() - $(this).height() < 100) {
                    $(window).unbind('scroll');
                    console.log(page);
                    LoadMore();
                }
            });
        }
    });
</script>
</html>
