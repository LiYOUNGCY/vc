<body>
<div class="main-wrapper">
    <!-- 顶部 -->
    <?php echo $top; ?>
    <div class="container">
        <div class="content edit">
            <form class="list" method="post" action="<?= base_url() ?>artist/publish/publish_artist">
                <div class="item">
                    <label for="title">专题标题：</label>
                    <input id="title" type="text">
                </div>
                <div class="item">
                    <label for="introduction">专题导语：</label>
                    <textarea id="introduction" rows="5"></textarea>
                </div>
                <div class="item">
                    <h3>作品列表</h3>
                </div>
                <div class="item" id="art_item">
                    <div class="production">
                        <div class="group">
                            <i class="fa fa-trash-o fa-fw" title="删除"></i>
                            <i class="fa fa-angle-up" title="上移"></i>
                            <i class="fa fa-angle-down" title="下移"></i>
                        </div>
                        <div class="item">
                            <label for="">作品标题：</label>
                            <input type="text">
                        </div>
                        <div class="item">

                            <label>作品的介绍：</label>
                            <textarea rows="5"></textarea>
                        </div>
                        <div class="image">
                            <img src="<?= base_url() ?>public/img/nrjpinzl4.jpg-w720.jpg">
                        </div>
                    </div>

                    <div class="production">
                        <div class="group">
                            <i class="fa fa-trash-o fa-fw" title="删除"></i>
                            <i class="fa fa-angle-up" title="上移"></i>
                            <i class="fa fa-angle-down" title="下移"></i>
                        </div>
                        <div class="item">
                            <label for="">作品标题：</label>
                            <input type="text">
                        </div>
                        <div class="item">

                            <label>作品的介绍：</label>
                            <textarea rows="5"></textarea>
                        </div>
                        <div class="image">
                            <img src="http://hanzh.oss-cn-shenzhen.aliyuncs.com/public/production/1440000992_2.jpg">
                        </div>
                    </div>

                    <div class="production">
                        <div class="group">
                            <i class="fa fa-trash-o fa-fw" title="删除"></i>
                            <i class="fa fa-angle-up" title="上移"></i>
                            <i class="fa fa-angle-down" title="下移"></i>
                        </div>
                        <div class="item">
                            <label for="">作品标题：</label>
                            <input type="text">
                        </div>
                        <div class="item">

                            <label>作品的介绍：</label>
                            <textarea rows="5"></textarea>
                        </div>
                        <div class="image">
                            <img src="http://hanzh.oss-cn-shenzhen.aliyuncs.com/public/production/1439471162_5.jpg">
                        </div>
                    </div>
                </div>

                <div class="item" style="text-align: center">
                    <i id="show_list" class="fa fa-plus"></i>
                </div>
                <div class="options">
                    <div class="btn preview">预览</div>
                    <div class="btn cancel">取消</div>
                    <div id="save" class="btn save">保存</div>
                </div>
            </form>

            <!--            弹出层  -->
            <div id="production" class="production_list hidden">
                <div class="list" id="production_list">
                    <i id="close" class="fa fa-close"
                       style="font-size: 24px; float:right; cursor: pointer;z-index: 999;"></i>

<!--                    <div class="pro">-->
<!--                        <div class="intro">-->
<!--                            <h3 class="title">八宝茶</h3>-->
<!---->
<!--                            <div class="content">宫廷秘制八宝茶，含有红枣干、葡萄干、枸杞、桂圆、冰糖、金桔干、芝麻、菊花，功效也是棒棒哒：改善血脂、降低胆固醇、降血压、美容养颜、调理气血-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <img src="--><?//= base_url() ?><!--public/img/nrjpinzl4.jpg-w720.jpg">-->
<!--                    </div>-->


                </div>
            </div>
            <!--            END 弹出层  -->
        </div>
    </div>
</div>
</body>
<script>
    function close() {
        $('body').css('overflow', '');
        $('#production').addClass('hidden');
    }

    function open() {
        $('#production').removeClass('hidden');
        $('body').css('overflow', 'hidden');
    }
    $(function () {
        var page = 0;

        $('#show_list').click(function () {
            open();
        });

        $('#close').click(function () {
            close();
        });

        $.ajax({
            type: 'post',
            url: GET_PRODUCTION_URL,
            data: {
                page
            },
            dataType: 'json',
            success: function (data) {
                page++;
                for (var i = 0; i < data.length; i++) {
                    var title = data[i].name;
                    var img = data[i].pic;
                    var content = data[i].intro;

                    var $box = $('<div class="pro"> <div class="intro"> <h3 class="title">' + title + '</h3> <div class="content">' + content + '</div> </div> <img src="' + img + '"> </div>');

                    //注册事件
                    $box.click(AddProduction);
                    $('#production_list').append($box);
                }
            }
        });


        $('.pro').click(AddProduction);

        //删除事件
        $('.fa-trash-o').click(remove);

        //上移事件
        $('.fa-angle-up').click(moveUp);
        //下移事件
        $('.fa-angle-down').click(moveDown);

        function moveUp() {
            console.log('up');
            var $item = $(this).parent().parent();

            var $prevItem = $item.prev();
            console.log($prevItem);
            //该元素不是第一个
            if ($prevItem.length == 1) {
                $production = $('<div class="production">' + $item.html() + '</div>');
                $prevItem.before($production);
                $production.find('.fa-angle-up').click(moveUp);
                $production.find('.fa-angle-down').click(moveDown);
                $production.find('.fa-trash-o').click(remove);
                $item.remove();
            }
        }

        function moveDown() {
            console.log('moveDown');
            var $item = $(this).parent().parent();
            var $afterItem = $item.next();

            if ($afterItem.length == 1) {
                $production = $('<div class="production">' + $item.html() + '</div>');
                $afterItem.after($production);
                $production.find('.fa-angle-up').click(moveUp);
                $production.find('.fa-angle-down').click(moveDown);
                $production.find('.fa-trash-o').click(remove);
                $item.remove();
            }
        }

        function remove() {
            console.log('remove');
            var $item = $(this).parent().parent();
            $item.remove();
        }

        function AddProduction() {
            console.log('add production');
            var img = $(this).children('img').attr('src');
            img = img.replace(/thumb1/g, "thumb2");

            console.log(img);
            $box = $('<div class="production"> <div class="group"> <i class="fa fa-trash-o fa-fw" title="删除"></i> <i class="fa fa-angle-up" title="上移"></i> <i class="fa fa-angle-down" title="下移"></i> </div> <div class="item"> <label for="">作品标题：</label> <input type="text"> </div> <div class="item"> <label>作品的介绍：</label> <textarea rows="5"></textarea> </div> <div class="image"> <img src="' + img + '"> </div> </div>');
            $box.find('.fa-angle-up').click(moveUp);
            $box.find('.fa-angle-down').click(moveDown);
            $box.find('.fa-trash-o').click(remove);

            close();
            $('#art_item').append($box);
        }
    });
</script>
</html>