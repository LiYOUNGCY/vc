<body>

<div class="main-wrapper">
    <!-- 顶部 -->
    <?php echo $top; ?>
    <!-- 主体 -->
    <div class="container">
        <div class="personal">
            <div class="userinfo clearfix">
                <div class="uhead">
                    <img src="<?= $user['pic'] ?>">
                </div>
                <div class="info">
                    <ul>
                        <li><label>昵称</label>：<?= $user['name'] ?></li>
                        <li><label>收货地址</label>：<?php echo 1 ? "空" : $user['address']; ?></li>
                        <li><label>联系电话</label>：<?php echo 1 ? "空" : $user['tel']; ?></li>
                        <li><label>联系人</label>：</li>
                    </ul>
                    <a href="<?= base_url() ?>setting">
                        <div class="editinfo btn">修改信息</div>
                    </a>
                </div>
            </div>
            <div class="ptitle">
                个人中心
            </div>
            <div class="pmenu">
                <ul>
                    <li class="active">
                        <a href="javascript:void(0);">
                            <div class="icon plike"></div>
                            <div class="mt">我的喜欢</div>
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url() ?>transaction">
                            <div class="icon pbuyed"></div>
                            <div class="mt">购买记录</div>
                        </a>
                    </li>
                    <li class="tc">
                        <a href="<?= base_url() ?>cart">
                            <div class="icon pcart"></div>
                            <div class="mt">购物车</div>
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url() ?>msg">
                            <div class="icon pmsg"></div>
                            <div class="mt">信息</div>
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url() ?>setting/safe">
                            <div class="icon psetting"></div>
                            <div class="mt">安全设置</div>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="psubmenu">
                <div class="active">赞过的文章</div>
                &nbsp; / &nbsp;
                <div><a href="<?= base_url() ?>like/production">赞过的作品</a></div>
            </div>
            <div class="item-list" id="item-list">

            </div>
        </div>
    </div>
    <?php echo $footer; ?>
</div>
<script type="text/javascript" src="<?= base_url() ?>public/js/swiper.min.js"></script>
</body>
<script>
    $(function () {
        var $container = $('.item-list');
        var container = document.querySelector('.item-list');
        var page = 0;
        var url = GET_PERSONAL_LIKE_ARTICLE;
        var masonry = new Masonry(container, {
            itemSelector: '.box',
            columnWidth: 300,
            gutter: 30,
            isFitWidth: true,
            isAnimate: false
        });
        $container.imageloader({
            selector: '.image',
            each: function (elm) {
                console.log("load done");
                console.log(elm.width + " " + elm.height);
//                $(elm).parent().css({'height': elm.height, 'width': elm.width});
                masonry.layout();
            }
        });

        function LoadMore() {
            $.ajax({
                type: 'POST',
                url: url,
                async: false,
                data: {
                    page: page
                },
                dataType: 'json',
                success: function (data) {
                    var items = data;
                    sum = items.length;

                    if (items.error != null || items.length === 0) {
                        console.log('Error');
                        return;
                    }

                    page++;

                    for (var i = 0; i < items.length; i++) {

                        var article_id = items[i].article.article_id;
                        var article_title = items[i].article.article_title;
                        var article_content = items[i].article.article_content;
                        var img = items[i].article.article_image;
                        var like = items[i].article.like;
                        var read = items[i].article.read;


                        var box = $('<div class="box" onclick="readArticle(' + article_id + ')" style="height:360px;">' +
                            '<img class="image" src="' + BASE_URL + 'public/img/load.gif" data-src="' + img + '" alt=""/>' +
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
                                console.log(elm.width + " " + elm.height);
//                                $(elm).parent().css({'height': elm.height, 'width': elm.width});
                            },
                            callback: function (elm) {
                                console.log('loadding');
                                masonry.layout();
                            }
                        });
                        // -------------- End -------------
                    }
                }
            });
        }

        LoadMore();
    })

</script>
</html>
