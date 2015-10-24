<body>
<div class="main-wrapper">
    <?php echo $top; ?>
    <div class="container">
        <div class="item-list" id="item-list">

            <div id="stamp" class="filter-warp">
                <div class="filter clearfix">
                    <div class="filter">
                        <ul>
                            <li class="label">热门分类：</li>
                            <li class="<?php if ($get_tag == 0) {
    echo 'active';
} ?>" onclick="getArticleListBYtag('all')">全部</li>
                            <?php foreach ($tag as $key => $value) {
    ?>
                                <li class="<?php if ($get_tag == $value['id']) {
    echo 'active';
}
    ?>"
                                    onclick="getArticleListBYtag(<?= $value['id'] ?>)">
                                    <?= $value['name'] ?></li>
                            <?php 
} ?>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <?= $footer ?>
</div>
</body>
<script>

    function getArticleListBYtag(tag_id) {
        if (tag_id == 'all') {
            window.location.href = BASE_URL + 'article';
        }
        else {
            window.location.href = BASE_URL + 'article?tag=' + tag_id;
        }
    }

    $(function () {
        'use strict';

        var $container = $('.item-list');
        var container = document.querySelector('#item-list');
        var page = 0;
        var tag = getQueryString('tag');
        var url = '';

        if (tag != null) {
            url = GET_ARTICLE_URL + '?tag=' + tag;
        }
        else {
            url = GET_ARTICLE_URL;
        }

        var masonry = new Masonry(container, {
            stamp: '#stamp',
            itemSelector: '.box',
            columnWidth: 300,
            gutter: 30,
            isFitWidth: true,
            isAnimate: true
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
                async: false,
                data: {
                    page: page,
                    type: 'article'
                },
                dataType: 'json',
                success: function (data) {
                    var items = data;
                    sum = items.length;

                    if (items.error != null || items.length === 0) {
//                        console.log('Error');
                        //失败处理
                        return;
                    }

                    page++;
                    for (var i = 0; i < items.length; i++) {
                        var article_id = items[i].content.article_id;
                        var article_title = items[i].content.sort_title;
                        var article_content = items[i].content.article_content;
                        var img = items[i].content.article_image;
                        var like = items[i].like;
                        var read = items[i].read;


                        var box = $('<div class="box">' +
                            '<a href="<?=base_url()?>article/'+ article_id +'">' +
                            '<div class="image" style="background-image:url(' + img + ')"></div>' +
                            '<p class="title">' + article_title + '</p>' +
                            '<p class="content">' + article_content + '</p>' +
                            '<div class="bottom">' +
                            '<div class="like">' +
                            '<span>' + like + '</span>' +
                            '<div class="icon like"></div>' +
                            '</div>' +
                            '<div class="read">' +
                            '<span>' + read + '</span>' +
                            '<i class="fa fa-eye"></i>' +
                            '</div>' +
                            '</div>' +
                            '</a>' +
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
                            },
                            callback: function (elm) {
                                masonry.layout();
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
                    LoadMore();
                }
            });
        }
    });
</script>
</html>
