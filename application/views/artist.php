<body>

<div class="main-wrapper">
    <?php echo $top; ?>
    <div class="container">
        <div class="item-list">

<!--                            <div class="artist">-->
<!--                                <article class="material-card Yellow">-->
<!--                                    <h2>-->
<!---->
<!--                                        <span><i class="fa fa-fw fa-star"></i>Mr Chen</span>-->
<!--                                    </h2>-->
<!---->
<!--                                    <div class="mc-content">-->
<!--                                        <div class="img-container">-->
<!--                                            <img class="img-responsive"-->
<!--                                                 src="" data-src="http://hanzh.oss-cn-shenzhen.aliyuncs.com/public/headpic/1439898381_2.jpg">-->
<!--                                        </div>-->
<!--                                        <div class="mc-description">-->
<!--                                            因为长得比较帅，成为设计师也是无可厚非的-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                    <a class="mc-btn-action">-->
<!--                                        <i class="fa fa-bars"></i>-->
<!--                                    </a>-->
<!---->
<!--                                    <div class="mc-footer">-->
<!--                                        <div class="btn read">See More</div>-->
<!--                                    </div>-->
<!--                                </article>-->
<!--                            </div>-->

        </div>
    </div>
    <?php echo $footer; ?>
</div>
<script>
    function a(id) {
        window.location.href = BASE_URL + 'artist/' + id;
    }
    $(function () {
        var page = 0;

        var container = document.querySelector('.item-list');
        var $container = $('.item-list');

        var masonry = new Masonry(container, {
            itemSelector: '.artist',
            columnWidth: 300,
            gutter: 30,
            isFitWidth: true,
            isAnimate: true
        });

        $container.imageloader({
            selector: '.img-responsive',
            each: function (elm) {
                masonry.layout();
            }
        });

        var color = [];

        LoadMore();
        WindowEvent();

        $('.material-card > .mc-btn-action').click(clickEvent);

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

        function clickEvent() {
            console.log('dd');
            var card = $(this).parent('.material-card');
            var icon = $(this).children('i');
            icon.addClass('fa-spin-fast');

            if (card.hasClass('mc-active')) {
                card.removeClass('mc-active');

                window.setTimeout(function () {
                    icon
                        .removeClass('fa-arrow-left')
                        .removeClass('fa-spin-fast')
                        .addClass('fa-bars');

                }, 800);
            } else {
                card.addClass('mc-active');

                window.setTimeout(function () {
                    icon
                        .removeClass('fa-bars')
                        .removeClass('fa-spin-fast')
                        .addClass('fa-arrow-left');

                }, 800);
            }
        }

        var count = 0;
        var sum = 0;

        function LoadMore() {
            $.ajax({
                type: 'post',
                url: GET_ARTIST_LIST,
                data: {
                    'page': page
                },
                dataType: 'json',
                success: function (data) {
                    sum = data.length;
                    console.log(sum);
                    if (typeof data.error != 'undefined') {

                        return FALSE;
                    }

                    page++;


                    for (var i = 0; i < data.length; i++) {
                        var id = data[i].id;
                        var name = data[i].name;
                        var content = data[i].intro;
                        var img = data[i].pic;
                        var box = $('<div class="artist">' +
                            '<article class="material-card Yellow">' +
                            '<h2>' +

                            '<span><i class="fa fa-fw fa-star"></i>' + name + '</span>' +
                            '</h2>' +

                            '<div class="mc-content">' +
                            '<div class="img-container">' +
                            '<img class="img-responsive" src="'+BASE_URL+'public/img/load.gif"'  +
                            'data-src="' + img + '">' +
                            '</div>' +
                            '<div class="mc-description">' + content + '</div>' +
                            '</div>' +
                            '<a class="mc-btn-action">' +
                            '<i class="fa fa-bars"></i>' +
                            '</a>' +

                            '<div class="mc-footer">' +
                            '<div class="btn read" onclick="a(' + id + ')">See More</div>' +
                            '</div>' +
                            '</article>' +
                            '</div>');

                        $('.item-list').append(box);
                        masonry.appended(box);

                        $(box).imageloader({
                            selector: '.img-responsive',
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

                        // Add Event
                        box.find('.mc-btn-action').click(clickEvent);


                    }
                }
            });
        }
    });
</script>

</body>
</html>
