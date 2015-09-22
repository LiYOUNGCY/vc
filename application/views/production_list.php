<body>
<div class="main-wrapper">
    <?php echo $top; ?>
    <div class="container">
        <div class="item-list">
            <div class="filter-warp" id="filter">
                <div class="filter clearfix">
                    <select class="dropdown" id="medium" onchange="TouchEvent()">
                        <option value="0">全部艺术门类</option>
                        <?php foreach ($medium as $key => $value) { ?>
                            <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                        <?php } ?>
                    </select>

                    <select class="dropdown" id="style" onchange="TouchEvent()">
                        <option value="0">全部风格</option>
                        <?php foreach ($style as $key => $value) { ?>
                            <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                        <?php } ?>
                    </select>

                    <select class="dropdown" id="selectPrice" onchange="TouchEvent()">
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
    function a(id) {
        window.location.href = BASE_URL + 'production/' + id;
    }

    function TouchEvent(){
        var medium = $('#medium').val();
        var style = $('#style').val();
        var price = $('#selectPrice').val();

        window.location.href = BASE_URL + 'production?m='+medium+'&&s='+style+'&&p='+price;
    }

    var s = '';
    var m = '';
    var p = '';

    $(function () {
        'use strict';

        s = getQueryString('s');
        m = getQueryString('m');
        p = getQueryString('p');

        $('#medium').easyDropDown({
            cutOff: 10,
            onChange: function (selected) {
                // do something
                console.log(11111);
                alert(selected);
            }
        });
        var style = $('#style');
        style.easyDropDown({
            cutOff: 10,
            onChange: function (selected) {
                console.log(11111);
                alert(selected);
            }
        });
        var selectPrice = $('#selectPrice');
        selectPrice.easyDropDown({
            cutOff: 10,
            onChange: function (selected) {
                console.log(11111);
                alert(selected);
            }
        });

        var $container = $('.item-list');
        var container = document.querySelector('.item-list');
        var page = 0;

        var masonry = new Masonry(container, {
            stamp: '.filter-warp',
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

        var sum = 0;
        var count = 0;

        function LoadMore() {
            var url = '';
            if(s == 0 && m == 0 && p == 0) {
                url = GET_PRODUCTION_URL;
            }
            else {
                url = GET_PRODUCTION_URL + '?m='+m+'&&s='+s+'&&p='+p;
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
                    console.log(data);
                    var items = data;

                    if (items.error != null || items.length === 0) {
                        console.log('Error');
                        return;
                    }

                    page++;
                    sum = items.length;
                    console.log(sum);

                    for (var i = 0; i < items.length; i++) {
                        console.log(items[i]);
                        // var items[i].content = items[i].content;
                        var id = data[i].id;
                        var title = data[i].name;
                        var author = data[i].artist.name;
                        var price = data[i].price;
                        var img = data[i].pic;
                        var like = data[i].like;
                        var type = data[i].type;
                        var l = data[i].l;
                        var w = data[i].w;


                        var box = $('<div class="production" onclick="a(' + id + ')">' +
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

                                count++;
                                if (count == sum) {
                                    //Add Event
                                    WindowEvent();
                                    count = 0;
                                }
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
