<body>
<div class="main-wrapper">
    <?php echo $top; ?>
    <div class="container">
        <div class="filter-warp">
            <div class="filter">
                <ul class="fc-target">
                    <li>标签1的类型：</li>
                    <li><a href="" class="link">小清新</a></li>
                    <li><a href="" class="link">惊喜</a></li>
                    <li><a href="" class="link">乱七八糟</a></li>
                </ul>
            </div>
            <div class="filter">
                <ul class="fc-target">
                    <li>标签2的类型：</li>
                    <li><a href="" class="link">小清新</a></li>
                    <li><a href="" class="link">惊喜</a></li>
                    <li><a href="" class="link">乱七八糟</a></li>
                </ul>
            </div>
            <div class="filter">
                <ul class="fc-target">
                    <li>标签3的类型：</li>
                    <li><a href="" class="link">小清新</a></li>
                    <li><a href="" class="link">惊喜</a></li>
                    <li><a href="" class="link">乱七八糟</a></li>
                </ul>
            </div>
        </div>
        <div class="article-list" id="article-list">
            <?php for ($i = 0; $i < 13; $i++) { ?>
                <div class="box">
                    <img class="image" src="http://img02.liwushuo.com/image/150409/gu40pimlg.jpg-w720" alt=""/>

                    <p class="title">标题：我的世界</p>

                    <p class="content">
                        这是一段介绍因为爱爱爱爱爱爱爱爱啊啊这是一段介绍因为爱爱爱爱爱爱爱爱啊啊这是一段介绍因为爱爱爱爱爱爱爱啊啊这是一段介绍因为爱爱爱爱爱爱爱爱啊啊dasfdasfdasfdasfdasfdasfdasfssfffffffffffffdsafdasfdasfdasfdasfdasfdasfdasf
                    </p>

                    <div class="bottom clearfix">
                        <div class="like" style="float: right;">
                            <span>199</span>
                            <i class="fa fa-heart"></i>
                        </div>
                    </div>
                </div>
            <?php } ?>

        </div>

        <?php echo $footer; ?>
    </div>
</div>
</body>
<script>

    function readArticle(id) {
        window.location.href = BASE_URL + 'article/' + id;
    }


    $(function () {
        'use strict';

        var $container = $('.article-list');
        var container = document.querySelector('#article-list');
        var page = 0;

        var masonry = new Masonry(container, {
            stamp: '.menu',
            itemSelector: '.box',
            columnWidth: 300,
            gutter: 30,
            isFitWidth: true,
            isAnimate: true
        });

        $container.imageloader({
            selector: '.image',
            each: function (elm) {
                console.log("load done");
                console.log(elm.width + " " + elm.height);
                $(elm).parent().css({'height': elm.height, 'width': elm.width});
                masonry.layout();
            }
        });

        var count = 0;
        var sum = 0;

//        function LoadMore() {
//            $.ajax({
//                type: 'POST',
//                url: GET_ARTICLE_URL,
//                async: false,
//                data: {
//                    page: page,
//                    type: 'article'
//                },
//                dataType: 'json',
//                success: function (data) {
//                    // var items = eval('(' + data + ')');
//                    var items = data;
//                    sum = items.length;
//
//                    if (items.error != null || items.length === 0) {
//                        console.log('Error');
//                        return;
//                    }
//
//                    page++;
//
//                    for (var i = 0; i < items.length; i++) {
//                        // var items[i].content = items[i].content;
//
//                        var article_id = items[i].content.article_id;
//                        var article_title = items[i].content.sort_title;
//                        var article_content = items[i].content.article_content;
//                        var img = items[i].content.article_image;
//                        var like = items[i].like;
//                        var read = items[i].read;
//
//
//                        var box = $('<div class="box"><div class="ishadow" onclick="readArticle(' + article_id + ')"><img class="image" id="img_load_' + page + '" src="<?//=base_url()?>//public/img/load.gif" data-src="' + img + '" data-url="' + img + '"/><div class="shadow"><i class="fa fa-eye"></i></div></div><p class="title">' + article_title + '</p><p class="content">' + article_content + '</p><div class="bottom clearfix"><div class="like"><i class="fa fa-heart"></i><span>' + like + '</span></div><div class="read"><i class="fa fa-eye"></i><span>' + read + '</span></div><div class="btn read" onclick="readArticle(' + article_id + ')">阅读详情</div></div></div>');
//                        $container.append(box);
//                        masonry.appended(box);
//
//                        $(box).imageloader({
//                            each: function (elm) {
//                                masonry.layout();
//                                console.log(elm.width + " " + elm.height);
//                                $(elm).parent().css({'height': elm.height, 'width': elm.width});
//
//                                count++;
//                                if (count == sum) {
//                                    //Add Event
//                                    WindowEvent();
//                                    count = 0;
//                                }
//                            },
//                            callback: function (elm) {
//                                console.log('loadding');
//                                masonry.layout();
//                            }
//                        });
//                        // -------------- End -------------
//                    }
//                }
//            });
//        }

        LoadMore();

        $(document).click(function () {
            console.log('click');
            LoadMore();
        });

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
