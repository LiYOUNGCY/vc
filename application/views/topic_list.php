<body>
<div class="main-wrapper">
    <?php echo $top; ?>
    <div class="container">

        <div class="item-list" id="item-list">
            <!--标签-->
            <div id="stamp" class="filter-warp">
                <div class="filter">
                    <ul class="fc-target clearfix">
                        <li class="label">标签1的类型：</li>
                        <li class="<?php if($get_tag == 0) echo 'active'; ?>"><a href="javascript:void(0)" class="link" onclick="getArticleListBYtag('all')">全部</a></li>
                        <?php foreach ($tag as $key => $value) { ?>
                            <li class="<?php if($get_tag == $value['id']) echo 'active'; ?>"><a href="javascript:void(0)" class="link" onclick="getArticleListBYtag(<?= $value['id'] ?>)"><?= $value['name'] ?></a></li>
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

    function getArticleListBYtag(tag_id) {
        if(tag_id == 'all') {
            window.location.href = TOPIC_URL;
        }
        else {
            window.location.href = TOPIC_URL + '?tag=' + tag_id;
        }
    }

    $(function () {
        'use strict';

        var tag = getQueryString('tag');
        var url = '';

        if (tag != null) {
            url = GET_TOPIC_URL + '?tag=' + tag;
        }
        else {
            url = GET_TOPIC_URL;
        }


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
