<body>

<div class="main-wrapper">
    <?php echo $top; ?>
    <div class="container">
        <div class="item-list">
<!--             <div class="artist" >
                <div class="backcard">
                    <div class="artistinfo">
                        <div class="head">
                            <img src="http://hanzh.oss-cn-shenzhen.aliyuncs.com/public/headpic/1439898381_2.jpg">
                        </div>
                        <div class="name">鸡巴白</div>
                    </div>
                    <div class="intro">
                        <p>
                            阿萨德阿萨德阿萨德请问告诉对方的身份多少个地方规定收费撒旦水电费撒旦方式发第三方第三方第三方电放费第三方士大夫是大方的说法大哥大概后天仍然有具体聚集发挥好放到他认为认为
                        </p>
                    </div>
                </div>
                <div class="artistcard">
                    <div class="artistpic">
                        <img src="http://hanzh.oss-cn-shenzhen.aliyuncs.com/public/headpic/1439898381_2.jpg">
                    </div>
                    <div class="artistname">（<span class="name">鸡巴白</span>）</div>
                </div>
            </div> -->
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

        LoadMore();
        WindowEvent();
        var masonry = new Masonry(container, {
            itemSelector: '.artist',
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

        var count = 0;
        var sum = 0;

        function LoadMore() {
            $.ajax({
                type: 'post',
                url: GET_ARTIST_LIST,
                async: false,
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

                        var box = '' +
                        '<div class="artist" onclick="a('+ id +')">' +
                        '<div class="backcard">' +
                        '<div class="artistinfo">' +
                        '<div class="head">' +
                        '<img class="image" src="'+ img +'"></div>' +
                        '<div class="name">'+ name +'</div></div>' +
                        '<div class="intro">' +
                        '<p>'+ content +'</p></div></div>' +
                        '<div class="artistcard">' +
                        '<div class="artistpic">' +
                        '<img class="image" src="'+ img +'"></div>' +
                        '<div class="artistname">（<span class="name">'+ name +'</span>）</div>' +
                        '</div></div>';

                        $('.item-list').append(box);

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

                    }
                }
            });
        }
    });
</script>

</body>
</html>
