<body>
<div class="main-wrapper">
    <?php echo $top; ?>
    <div class="container">
        <div class="item-list">
            <div class="filter-warp" id="filter">
                <div class="filter clearfix" style="border: none;">
                    <select class="dropdown" id="medium">
                        <option value="0">全部艺术门类</option>
                        <?php foreach ($medium as $key => $value) { ?>
                            <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                        <?php } ?>
                    </select>

                    <select class="dropdown" id="style">
                        <option value="0">全部风格</option>
                        <?php foreach ($style as $key => $value) { ?>
                            <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                        <?php } ?>
                    </select>

                    <select class="dropdown" id="price">
                        <option value="0">全部价格</option>
                        <?php foreach ($price as $key => $value) { ?>
                            <option value="<?= $value['value'] ?>"><?= $value['name'] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <!--            <div class="production">-->
            <!--                <img class="image" src="http://hanzh.oss-cn-shenzhen.aliyuncs.com/public/production/thumb1_1440593600_1.jpg">-->
            <!--                <p class="title">天梯</p>-->
            <!--                <p class="author">作者：条野太郎</p>-->
            <!--                <div class="info">-->
            <!--                    <span class="type">油画</span>，-->
            <!--                    <span class="size">120cm X 90cm</span>-->
            <!--                </div>-->
            <!--                <div class="bottom clearfix">-->
            <!--                    <div class="vote" title="收藏"><i class="fa fa-heart"></i>99</div>-->
            <!--                    <div class="price" title="价格">￥199</div>-->
            <!--                </div>-->
            <!--            </div>-->

        </div>
    </div>
    <?php echo $footer; ?>
</div>
</body>
<script>
    /*************************************
     * 初始化：根据url的参数来设置 select 框的值
     * 根据 select 的值来设置 m s p
     *
     * 事件： select 的值改变， m s p 的值也改变
     * 事件：popstate 改变 m s p 的值
     *************************************/
    'use strict';

    function a(id) {
        window.location.href = BASE_URL + 'production/' + id;
    }

    var medium = $('#medium');
    var style = $('#style');
    var price = $('#price');
    var m, s, p;
    var $container = $('.item-list');
    var container = document.querySelector('.item-list');
    var sum = 0;
    var count = 0;
    var page = 0;
    var Select_status = true;

    var masonry = new Masonry(container, {
        stamp: '.filter-warp',
        itemSelector: '.production',
        columnWidth: 300,
        gutter: 25,
        isFitWidth: true,
        isAnimate: true
    });

    // 插件 imageloader
    $container.imageloader({
        selector: '.image',
        each: function (elm) {
            masonry.layout();
        }
    });

    // 为 select 注册事件
    medium.easyDropDown({
        onChange: function (selected) {
            if (Select_status) {
                TouchEvent();
            }
        }
    });

    style.easyDropDown({
        onChange: function (selected) {
            if (Select_status) {
                TouchEvent();
            }
        }
    });

    price.easyDropDown({
        onChange: function (selected) {
            if (Select_status) {
                TouchEvent();
            }
        }
    });


    RefreshUrlData();

    /**
     * 后退的操作
     */
    window.addEventListener('popstate', function (e) {
        RefreshUrlData();
        reloadpage();
    });


    LoadMore();


    WindowEvent();


    function RefreshUrlData() {
        m = getQueryString('m');
        s = getQueryString('s');
        p = getQueryString('p');

        m = m == null ? '0' : m;
        s = s == null ? '0' : s;
        p = p == null ? '0' : '"'+p+'"';


        //刷新 select 的值
        Select_status = false;
        medium.easyDropDown('select', m.toString());
        style.easyDropDown('select', s.toString());
        price.easyDropDown('select', p);
        Select_status = true;
    }

    function TouchEvent() {
        var url = BASE_URL + 'production?m=' + medium.val() + '&&s=' + style.val() + '&&p=' + price.val();
        window.history.pushState(null, null, url);
        reloadpage();
    }

    function reloadpage() {
        //重置 page
        page = 0;
        var $container = $('.item-list > .production');
        $container.each(function () {
            $(this).remove();
        });
        LoadMore();
    }


    function LoadMore() {
        var url = '';
        var s = style.val();
        var m = medium.val();
        var p = price.val();

        if (m == 0 && s == 0 && p == 0) {
            url = GET_PRODUCTION_URL;
        }
        else {
            url = GET_PRODUCTION_URL + '?m=' + m + '&&s=' + s + '&&p=' + p;
        }
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

                if (items.error != null || items.length === 0) {
                    console.log('Error');
                    return;
                }

                page++;
                sum = items.length;

                for (var i = 0; i < items.length; i++) {
                    var id = data[i].id;
                    var title = data[i].name;
                    var author = data[i].artist.name;
                    var price = data[i].price;
                    var img = data[i].pic;
                    var like = data[i].like;
                    var style = data[i].style;
                    var l = data[i].l;
                    var w = data[i].w;


                    var box = $('<div class="production" onclick="a(' + id + ')">' +
                        '<img class="image" src="' + img + '">' +
                        '<p class="title">' + title + '</p>' +
                        '<p class="author">作者：' + author + '</p>' +
                        '<div class="info">' +
                        '<span class="type">' + style + '</span>，' +
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


    function WindowEvent() {

        $(window).scroll(function () {
            // 当滚动到最底部以上100像素时， 加载新内容
            if ($(document).height() - $(this).scrollTop() - $(this).height() < 100) {
                $(window).unbind('scroll');
                LoadMore();
            }
        });
    }
</script>
