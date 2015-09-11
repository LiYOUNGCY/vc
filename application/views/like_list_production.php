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
                <div><a href="<?= base_url() ?>like">赞过的文章</a></div>
                &nbsp; / &nbsp;
                <div class="active">赞过的作品</div>
            </div>
            <div class="item-list" id="item-list">


            </div>
        </div>
    </div>
    <?php echo $footer; ?>
</div>
<?php
if ($user['role'] == 0) {
    echo $sign;
}
?>
<script type="text/javascript" src="<?= base_url() ?>public/js/swiper.min.js"></script>
</body>
<script>


    function a(id) {
        window.location.href = BASE_URL + 'production/' + id;
    }

    $(function () {
        'use strict';

        var $container = $('.item-list');
        var container = document.querySelector('.item-list');
        var page = 0;

        var masonry = new Masonry(container, {
            itemSelector: '.production',
            columnWidth: 300,
            gutter: 25,
            isFitWidth: true,
            isAnimate: true
        });

        $container.imageloader({
            selector: '.image',
            each: function (elm) {
                masonry.layout();
            }
        });


        function LoadMore() {
            $.ajax({
                type: 'POST',
                url: GET_PERSONAL_LIKE_PRODUCTION,
                async: false,
                data: {
                    page: page
                },
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    var items = data;

                    if (items.error != null || items.length === 0) {
                        console.log('Error');
                        return;
                    }

                    page++;


                    for (var i = 0; i < items.length; i++) {
                        console.log(items[i]);
                        // var items[i].content = items[i].content;
                        var id = data[i].production.id;
                        var title = data[i].production.name;
                        var author = data[i].production.aid;
                        var price = data[i].production.price;
                        var img = data[i].production.pic;
                        var like = data[i].production.like;
                        var type = data[i].production.type;
                        var l = data[i].production.l;
                        var w = data[i].production.w;


                        var box = $('<div class="production">' +
                            '<img class="image" src="' + img + '">' +
                            '<p class="title">' + title + '</p>' +
                            '<p class="author">作者：' + author + '</p>' +
                            '<div class="info">' +
                            '<span class="type">' + type + '</span>，' +
                            '<span class="size">' + w + 'cm X ' + l + 'cm</span>' +
                            '</div>' +
                            '<div class="bottom clearfix">' +
                            '<div class="price" title="价格">' + price + ' RMB</div>' +
                            '<div class="vote" title="收藏">' + like + '<div class="icon like"></div></div>' +
                            '</div>' +
                            '</div>');

                        $container.append(box);
                        masonry.appended(box);

                        $(box).imageloader({
                            selector: '.image',
                            each: function (elm) {
                                masonry.layout();
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

//         END LoadMore

        LoadMore();


    });
</script>
</html>
