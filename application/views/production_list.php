<body>
<div class="main-wrapper">
    <?php echo $top; ?>
    <div class="container">
        <div class="item-list">

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

        var count = 0;
        var sum = 0; //


        function LoadMore() {
            $.ajax({
                type: 'POST',
                url: GET_PRODUCTION_URL,
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


                        var box = $('<div class="production">' +
                            '<img class="image" src="'+img+'">' +
                            '<p class="title">'+title+'</p>' +
                            '<p class="author">作者：'+author+'</p>' +
                        '<div class="info">' +
                            '<span class="type">'+type+'</span>，' +
                    '<span class="size">'+w+'cm X '+l+'cm</span>' +
                        '</div>' +
                        '<div class="bottom clearfix">' +
                            '<div class="price" title="价格">'+price+' RMB</div>' +
                            '<div class="vote" title="收藏">'+like+'<div class="icon like"></div></div>' +
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
