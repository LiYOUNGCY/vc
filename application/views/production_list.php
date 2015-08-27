<body>

<div class="main-wrapper">
    <?php echo $top; ?>
    <div class="container">
        <!--        <div class="margin-top">-->

        <div class="new-art">
            <div class="list" id="art-list">

                <!--                        <div class="item">-->
                <!--                            <figure class="effect-bubba">-->
                <!--                                <div class="art-image">-->
                <!--                                    <img src="http://hanzh.oss-cn-shenzhen.aliyuncs.com/public/production/thumb1_1440593600_1.jpg" alt="" class="image" style="width: 298px">-->
                <!--                                </div>-->
                <!--                                <figcaption>-->
                <!--                                    <p>类型：油画<br>尺寸：20 * 30 cm</p>-->
                <!--                                </figcaption>-->
                <!--                            </figure>-->
                <!--                            <div class="art-title">我的世界</div>-->
                <!--                            <div class="author">作者：鸡巴白</div>-->
                <!--                            <ul class="art-info">-->
                <!--                                <li><i class="fa fa-heart-o"></i> 999</li>-->
                <!--                                <!--<li><i class="fa fa-eye"></i></li>-->
                <!--                                <div class="price">20000 RMB</div>-->
                <!--                            </ul>-->
                <!--                        </div>-->

            </div>
        </div>

        <!--        </div>-->
        <?php echo $footer; ?>
    </div>
</div>

<script>
    function a(id) {
        window.location.href = BASE_URL + 'production/' + id;
    }
    $(function () {
        'use strict';

        var $container = $('.list');
        var container = document.querySelector('.list');
        var page = 0;

        var masonry = new Masonry(container, {
            itemSelector: '.item',
            columnWidth: 300,
            gutter: 25,
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
        var sum = 0; //


        function LoadMore() {
            $.ajax({
                type: 'POST',
                url: GET_PRODUCTION_URL,
                data: {
                    page: page
                },
                dataType: 'json',
                success: function (data) {
                    // var items = eval('(' + data + ')');
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


                        var box = $('<div class="item" onclick="a(' + id + ')">' +
                            '<figure class="effect-bubba">' +
                            '<div class="art-image" style="height: auto;">' +
                            '<img src="' + img + '" alt="" class="image" style="width: 300px; border: none;">' +
                            '</div>' +
                            '<figcaption>' +
                            '<p>类型：' + type + '<br>尺寸：' + l + ' * ' + w + ' cm</p>' +
                            '</figcaption>' +
                            '</figure>' +
                            '<div class="art-title">' + title + '</div>' +
                            '<div class="author">作者：' + author + '</div>' +
                            '<div class="art-info clearfix">' +
                            '<div class="vote"><i class="fa fa-heart-o"></i> ' + like + '</div>' +
                            '<div class="price">' + price + ' RMB</div>' +
                            '</div>' +
                            '</div>');
                        $container.append(box);
                        masonry.appended(box);

                        $(box).imageloader({
                            each: function (elm) {
                                masonry.layout();
                                console.log(elm.width + " " + elm.height);
                                $(elm).parent().css({'height': elm.height, 'width': elm.width});

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
