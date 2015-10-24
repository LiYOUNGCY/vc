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
                        <li><label>收货地址</label>：<?php echo 1 ? '空' : $user['address']; ?></li>
                        <li><label>联系电话</label>：<?php echo 1 ? '空' : $user['tel']; ?></li>
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
            <div class="nonebox">

            </div>
        </div>
    </div>
    <?php echo $footer; ?>
</div>
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
                    var items = data;

                    if (items.error != null || items.length === 0) {
                        if(page == 0){
                            var box = '' +
                            '<div class="box">' +
                            '<div class="text">您还没有喜欢的作品呢</div>' +
                            '<div class="go">快去看看吧！</div>' +
                            '<div class="opt">' +
                            '<div class="btn"><a href="<?=base_url()?>topic">专题推荐</a></div>' +
                            '<div class="btn"><a href="<?=base_url()?>production">精选作品</a></div>' +
                            '</div></div>';

                            $(".nonebox").append(box);
                        }
                        return;
                    }

                    page++;


                    for (var i = 0; i < items.length; i++) {
                        // var items[i].content = items[i].content;
                        var id = data[i].id;
                        var title = data[i].name;
                        var author = data[i].aid;
                        var price = data[i].price;
                        var img = data[i].pic;
                        var like = data[i].like;
                        var medium = data[i].medium;
                        console.log(medium);
                        var l = data[i].l;
                        var w = data[i].w;
                        var width = data[i].width;
                        var height = data[i].height;


                        var box = $('<div class="production">' +
                            '<img class="image" src="' + img + '" style="width: '+width+'px; height: '+height+'px;">' +
                            '<p class="title">' + title + '</p>' +
                            '<p class="author">作者：' + author + '</p>' +
                            '<div class="info">' +
                            '<span class="type">' + medium + '</span>，' +
                            '<span class="size">' + w + 'cm X ' + l + 'cm</span>' +
                            '</div>' +
                            '<div class="bottom clearfix">' +
                            '<div class="price" title="价格">' + price + ' RMB</div>' +
                            '<div class="vote" title="收藏">' + like + '<div class="icon like"></div></div>' +
                            '</div>' +
                            '</div>');

                        $container.append(box);
                        masonry.appended(box);




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
