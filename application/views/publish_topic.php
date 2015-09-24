<body>
<div class="main-wrapper">
    <!-- 顶部 -->
    <?php echo $top; ?>
    <div class="container">
        <div class="content edit">
            <form class="list" method="post" action="<?= base_url() ?>article/publish/publish_article">
                <div class="item">
                    <label for="title">专题标题：</label>
                    <input id="title" type="text" name="article_title" />
                </div>
                <input type="hidden" name="article_type" value="2"/>
                <input type="hidden" name="pids" />
                <input id="title" type="hidden" type="text" name="article_content" />
                <div class="item">
                    <label for="introduction">专题导语：</label>
                    <textarea id="introduction" rows="5"></textarea>
                </div>

                <div class="item">
                    <h3>作品列表</h3>
                </div>

                <div class="item" id="art_item">
<!--                    <div class="production">-->
<!--                        <div class="group">-->
<!--                            <i class="fa fa-trash-o fa-fw" title="删除"></i>-->
<!--                            <i class="fa fa-angle-up" title="上移"></i>-->
<!--                            <i class="fa fa-angle-down" title="下移"></i>-->
<!--                        </div>-->
<!--                        <div class="item">-->
<!--                            <label for="ptitle">作品标题：</label>-->
<!--                            <input type="text" id="ptitle">-->
<!--                        </div>-->
<!--                        <div class="item">-->
<!--                            <label>作品的介绍：</label>-->
<!--                            <textarea rows="5" id="pintro"></textarea>-->
<!--                        </div>-->
<!--                        <input type="hidden" id="pprice" value="99.00">-->
<!--                        <input type="hidden" id="pvote" value="58">-->
<!--                        <input type="hidden" id="pid" value="1">-->
<!---->
<!--                        <div class="image">-->
<!--                            <img src="--><?//= base_url() ?><!--public/img/nrjpinzl4.jpg-w720.jpg">-->
<!--                        </div>-->
<!--                    </div>-->
                </div>

                <!--                    按钮-->
                <div class="item" style="text-align: center">
                    <i id="show_list" class="fa fa-plus"></i>
                </div>
                <div class="options">
                    <div class="btn preview" id="preview">预览</div>
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
                    <!--                        <img src="">-->
                    <!--                    </div>-->


                </div>
            </div>
            <!--            END 弹出层  -->

            <div class="production_list hidden" id="previewTopic">
                <i id="PreviewClose" class="fa fa-close"
                   style="font-size: 48px; float:right; cursor: pointer;z-index: 999;"></i>

                <div class="article">
                    <h1 class="title" id="tctitle"></h1>

                    <div class="detail" id="content"></div>
                </div>
            </div>
        </div>
    </div>
    <?=$footer?>
</div>
</body>
<script>
    function close(tar) {
        $('body').css('overflow', '');
        $(tar).addClass('hidden');
    }

    function open(tar) {
        $(tar).removeClass('hidden');
        $('body').css('overflow', 'hidden');
    }
    $(function () {
        var page = 0;

        $('#show_list').click(function () {
            open('#production');
        });

        $('#close').click(function () {
            close('#production');
        });

        $.ajax({
            type: 'post',
            url: GET_PRODUCTION_URL,
            data: {
                page: page
            },
            dataType: 'json',
            success: function (data) {
                console.log(data);
                page++;
                for (var i = 0; i < data.length; i++) {
                    var id = data[i].id;
                    var like = data[i].like;
                    var price = data[i].price;
                    var title = data[i].name;
                    var img = data[i].pic;
                    var content = data[i].intro;

                    var $box = $('<div class="pro">' +
                        '<div class="intro">' +
                        '<h3 class="title">' + title + '</h3>' +
                        '<div class="content"> ' + content + '</div>' +
                        '<input type="hidden" value="' + id + '" id="pid">' +
                        '<input type="hidden" value="' + like + '" id="pvote">' +
                        '<input type="hidden" value="' + price + '" id="pprice">' +
                        '</div>' +
                        '<img src="' + img + '">' +
                        '</div>');

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

        //提交
        $('#save').click(function(){
            var pids = ReadProduction();
            console.log(pids);
            pids=pids.substring(0,pids.length-1)

            $("input[name=article_content]").val($("#content").html());
            $("input[name=pids]").val(pids);
            $("form").submit();
            /*
            $.ajax({
                type: 'post',
                url:POST_ARTICLE_URL,
                data: {
                    article_title: title,
                    article_type: 2,
                    pids: pids,
                    article_content: content
                },
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                }
            });
            */
        });

        //预览事件
        $('#preview').click(function () {
            //把内容写入弹出层里
            //title
            $('#tctitle').html($('#title').val());

            ReadProduction();

            open('#previewTopic');
        });

        $('#PreviewClose').click(function () {
            close('#previewTopic');
            $('#content').empty();
        });

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
            console.log(this);

            var id = $(this).find('#pid').val();
            var like = $(this).find('#pvote').val();
            var price = $(this).find('#pprice').val();

            console.log(id + " " + like + " " + price);

            img = img.replace(/thumb1/g, "thumb2");

            console.log(img);
            $box = $('<div class="production">' +
                '<div class="group">' +
                '<i class="fa fa-trash-o fa-fw" title="删除"></i>' +
                '<i class="fa fa-angle-up" title="上移"></i>' +
                '<i class="fa fa-angle-down" title="下移"></i>' +
                '</div>' +
                '<div class="item">' +
                '<label for="ptitle">作品标题：</label>' +
                '<input type="text" id="ptitle">' +
                '</div>' +
                '<div class="item">' +
                '<label>作品的介绍：</label>' +
                '<textarea rows="5" id="pintro"></textarea>' +
                '</div>' +
                '<input type="hidden" id="pprice" value="' + price + '">' +
                '<input type="hidden" id="pvote" value="' + like + '">' +
                '<input type="hidden" id="pid" value="' + id + '">' +

                '<div class="image">' +
                '<img src="' + img + '">' +
                '</div>' +
                '</div>');

            $box.find('.fa-angle-up').click(moveUp);
            $box.find('.fa-angle-down').click(moveDown);
            $box.find('.fa-trash-o').click(remove);

            close('#production');
            $('#art_item').append($box);
        }

        //读内容


        /**
         * @return {string}
         */
        function ReadProduction () {
            var pids = '';
            //导语
            $('#content').append('<div class="introduction">' + $('#introduction').val() + '</div>');
            var items = $('.production');
            $.each(items, function (i, value) {
                var id = $(items[i]).find('#pid').val();
                pids += id + ',';
                var title = $(items[i]).find('#ptitle').val();
                var intro = $(items[i]).find('#pintro').val();
                var img = $(items[i]).find('img').attr('src');
                var price = $(items[i]).find('#pprice').val();
                var vote = $(items[i]).find('#pvote').val();

//                console.log(title + " " + intro);

                var tar = $('<div class="item">' +
                    '<div class="tctop">' +
                    '<span class="order">'+(i+1)+'</span><span class="tctitle">' + title + '</span>' +
                    '</div>' +
                    '<p class="tccontent">' + intro + '</p>' +
                    '<img class="tcimage" src="' + img + '">' +
                    '<span class="tcprice">售价：<i class="fa fa-rmb" style="margin-right: 5px;"></i>' + price + '</span>' +
                    '<span class="vote"><i class="fa fa-heart" style="margin-right: 5px;"></i>' + vote + '</span>' +
                    '<a class="link" href="'+ BASE_URL +'production/'+ id + '"><i class="fa fa-hand-o-right"></i>查看详情</a>' +
                    '</div>');

                $('#content').append(tar);
            });

            return pids;
        }
    });
</script>
</html>
