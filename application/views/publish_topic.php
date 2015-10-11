<?php load_header(
    '发布专题',
    'base.css',
    'font-awesome/css/font-awesome.min.css',
    'edit_style.css',
    'alert.css',
    'easydropdown.css'
) ?>
<body style="position: relative;">
<!-- Sidebar -->
<div class="container-left" id="sidebar">
    <div class="title">
        <i class="fa fa-edit" style="font-size: 48px;"></i>

        <h3>发布专题</h3>
    </div>
    <nav>
        <ul>
            <li id="InsertParagraph">插入段落</li>
            <li id="InsertImage">插入图片</li>
            <li id="InsertProduction">插入艺术品</li>
        </ul>
    </nav>

</div>
</div>
<!-- Edit container -->
<div class="container open">
    <div class="article main-container">
        <label class="form-control" for="name">
            <span>标题：</span>
            <input class="title" type="text" id="title">
            <span class="message danger">标题不能为空</span>
        </label>
        <!--        <button type="button" class="button success" id="show" onclick="fadeInReveal()">提交</button>-->
        <!--        <button type="button" class="button">默认</button>-->
        <!--        <button type="button" class="button cancel">取消</button>-->
        <!--        <label class="form-control" for="name">-->
        <!--            <span>Name:</span>-->
        <!--            <input type="text" id="name">-->
        <!--            <span class="message danger">Name must at least three</span>-->
        <!--        </label>-->
        <!--        <label class="form-control" for="introduction">-->
        <!--            <span>Introduciton:</span>-->
        <!--            <textarea rows='1'></textarea>-->
        <!--            <span class="message">这里应该是一段介绍的话</span>-->
        <!--        </label>-->


        <div class="detail" id="main-container">
            <label class="form-control" for="introduction" data-type="introduction">
                <span>专题的介绍：</span>
                <textarea class="introduction" rows='1'></textarea>
                <span class="message danger">内容不能为空</span>
            </label>
        </div>
    </div>

    <div id="select" class="select clearfix">
        <p>所属标签</p>
        <select class="dropdown" id="who">
            <?php foreach ($tag['who'] as $key => $value) { ?>
                <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
            <?php } ?>
        </select>

        <select class="dropdown" id="where">
            <?php foreach ($tag['where'] as $key => $value) { ?>
                <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
            <?php } ?>
        </select>

        <select class="dropdown" id="when">
            <?php foreach ($tag['when'] as $key => $value) { ?>
                <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
            <?php } ?>
        </select>

        <div class="option">
            <button type="button" class="button" id="preview">预览</button>
            <button type="button" class="button success" id="save">保存</button>

        </div>
    </div>

    <!-- Reveal Model -->
    <div class="reveal-model-bg" id="reveal"></div>
    <div class="reveal-model">
        <div class="top">
            <div class="reveal-title">插入图片</div>
            <div class="close-box" id="reveal-close"><i class="fa fa-close"></i></div>
        </div>
        <div class="wrap" id="reveal-content">
        </div>
        <div class="footer" id="reveal-footer"></div>
    </div>


</body>
<script src="<?= base_url() ?>public/js/jquery.js"></script>
<script src="<?= base_url() ?>public/js/autosize.js"></script>
<script src="<?= base_url() ?>public/js/ajaxfileupload.js"></script>
<script src="<?= base_url() ?>public/js/alert.min.js"></script>
<script src="<?= base_url() ?>public/js/jquery.easydropdown.js"></script>
<script>

    var page = 0;
    var order = 1;
    $(function () {
        $('#show').click(function () {
            $(".message").toggleClass('open');
        });

        $('input').each(function () {
            $(this).blur(contentNullEvent);
        });

        $('textarea').each(function () {
            console.log(this);
            autosize(this);
            $(this).blur(contentNullEvent);
        });


        //插入段落的事件
        $('#InsertParagraph').click(function () {
            InsertParagraph('#main-container');
        });

        //插入图片
        $('#InsertImage').click(function () {
            InsertImage('#main-container');
        });

        //插入艺术品
        $('#InsertProduction').click(function () {
            InsertProduction('#main-container');
        });

        //预览
        $('#preview').click(function () {
            var code = _generateCode('#main-container');

            fadeInReveal();

            $('#reveal-content').append('<div class="article">' + code + '</div>');
        });

        //保存
        $('#save').click(function () {

            var title = $('#title').val();
            var content = _generateCode('#main-container');
            var who = $('#who').val();
            var when = $('#when').val();
            var where = $('#where').val();

            $.ajax({
                url: BASE_URL + 'topic/publish/save_topic',
                data: {
                    title: title,
                    content: content,
                    who: who,
                    when: when,
                    where: where
                },
                dataType: 'json',
                type: 'post',
                success: function (data) {
                    console.log(data);

                    if (data.error != null) {
                        swal('发布失败');
                    }

                    if (data.success == 0) {
                        window.location.href = BASE_URL + 'admin/topic';
                    }
                }
            });
        });
    });


    /**
     * 打开弹出层
     */
    function fadeInReveal() {
        var reveal = $('.reveal-model-bg');

        if (!reveal.hasClass('open')) {
            reveal.addClass('open');
            $('.reveal-model-bg').click(fadeOutReveal);
            $('#reveal-close').click(fadeOutReveal);
        }

        $('#reveal-content').html('');
        $('#reveal-footer').html('');
    }


    /**
     * 关闭弹出层
     */
    function fadeOutReveal() {
        var reveal = $('.reveal-model-bg');

        if (reveal.hasClass('open')) {
            reveal.removeClass('open');
        }

        $('#reveal-content').html('');
        $('#reveal-footer').html('');
    }


    /**
     * 插入段落
     */
    function InsertParagraph(container) {
        $container = $(container);

        var $paragraph = $(
            '<label class="form-control" data-type="p">' +
            '<span>段落：</span>' +
            '<textarea rows="1" id="99"></textarea>' +
            '<span class="message danger">内容不能为空</span>' +
            '</label>');

        $container.append($paragraph);

        // autosize
        var textarea = $paragraph.children('textarea');
        autosize(textarea);
        //add contentNullEvent
        textarea.blur(contentNullEvent);
    }


    /**
     * 插入图像
     * @param container
     * @constructor
     */
    function InsertImage(container) {
        // Fade In Reveal
        fadeInReveal();

        $('#reveal-content').html('<label class="image-content" id="reveal-content" for="upfile">' +
            '<i class="fa fa-camera"></i>' +
            '<p>点击上传图片</p>' +
            '<input type="file" name="upfile" id="upfile" onchange="file_upload(\'' + container + '\')">' +
            '</label>');
    }


    /**
     * 插入艺术品
     */
    function InsertProduction(container) {
        $container = $(container);
        page = 0;

        fadeInReveal();

        $('#reveal-footer').html('<button type="button" class="button">加载更多</button>');
        $('#reveal-content').append('<div class="item-list search"></div>');
        $('#reveal-footer > button').click(LoadMoreProduction);
        LoadMoreProduction();
    }

    /**
     * 加载更多艺术品
     */
    function LoadMoreProduction() {
        $.ajax({
            type: 'POST',
            url: GET_PRODUCTION_URL,
            data: {
                page: page
            },
            async: false,
            dataType: 'json',
            success: function (data) {
                console.log(data);

                if (data.error != null) {
                    swal({
                        title: '无法获取数据',
                        type: 'warning'
                    });
                    return;
                }


                var reveal_container = $('#reveal-content > .item-list');

                for (var i = 0; i < data.length; i++) {
                    var item = data[i];
                    var id = item.id;
                    var title = item.name;
                    var pic = item.pic;
                    var intro = item.intro;
                    var price = item.price;
                    var time = item.create_time;
                    var like = item.like;

                    var $box = $('<div class="item clearfix" data-type="production" data-id="' + id + '" data-like="' + like + '">' +
                        '<div class="image-warp">' +
                        '<img class="image" src="' + pic + '">' +
                        '</div>' +
                        '<p class="title">' + title + '</p>' +
                        '<p class="time">' + time + '</p>' +

                        '<p class="content">' + intro + '</p>' +
                        '<div class="price">' + price + '</div>' + '</div>');

                    $box.click(InsertProductionToContainer);
                    reveal_container.append($box);
                }
            }
        });
    }

    function InsertProductionToContainer() {
        var $container = $('#main-container');
        $container.append();

        var id = $(this).attr('data-id');
        var pic = $(this).find('img').attr('src');
        var price = $(this).find('.price').html();
        var like = $(this).attr('data-like');

        var $box = $('<div class="item" data-type="production">' +
            '<div class="tctop">' +
            '<span class="order">' + (order++) + '</span>' +
            '<label class="form-control inline">' +
            '<input type="text" class="tctitle" placeholder="标题">' +
            '<span class="message danger">内容不能为空</span>' +
            '</label>' +
            '</div>' +
            '<label class="form-control" for="introduction">' +
            '<textarea class="tccontent" rows="1" placeholder="介绍"></textarea>' +
            '<span class="message danger">内容不能为空</span>' +
            '</label>' +
            '<img class="tcimage" src="' + pic + '">' +
            '<span class="tcprice">售价：' +
            '<i class="fa fa-rmb" style="margin-right:5px;"></i>' + price + '</span>' +
            '<span class="vote">' +
            '<i class="fa fa-heart" style="margin-right:5px;"></i>' + like + '</span>' +
            '<a class="link" href="http://localhost/artvc/production/' + id + '">' +
            '<i class="fa fa-hand-o-right"></i>查看详情' +
            '</a></div>');

        $container.append($box);

        $box.find('input').each(function () {
            $(this).blur(contentNullEvent);
        });

        $box.find('textarea').each(function () {
            $(this).blur(contentNullEvent);
            autosize(this);
        });

        fadeOutReveal();
    }


    /**
     * 上传图片
     * @param container
     */
    function file_upload(container) {
        $container = $(container);
        console.log('file upload');
        $.ajaxFileUpload({
            url: BASE_URL + 'publish/image/upload_image',
            fileElementId: 'upfile',
            dataType: 'JSON',
            type: 'post',
            success: function (data) {
                console.log(data);
                var src = data.image_path;

                //close Reveal
                fadeOutReveal();
                $image = $('<label class="form-control" data-type="image">' +
                    '<img src=' + src + '>' +
                    '</label');
                $container.append($image)
            },
            error: function (data) {
                console.log(data);
            }
        });
    }


    /**
     * 判断输入框里的内容是否为空
     * @returns {boolean}
     */
    function contentNullEvent() {
        var content = trim(content = $(this).val());
        var alert = $(this).next();

        if (content == null || content == '') {
            if (!$(alert).hasClass('open')) {
                $(alert).addClass('open');
            }
            return false;
        }
        else {
            if ($(alert).hasClass('open')) {
                $(alert).removeClass('open');
            }
            return true;
        }
    }


    function _generateCode(container) {
        var $container = $(container);

        var code = '';

        //判断所有输入框不能为空

        $container.children().each(function () {
            var item = $(this);
            if (item.attr('data-type') == 'introduction') {
                code += '<div class="introduction">' + item.find('textarea').val() + '</div>';
            }
            else if (item.attr('data-type') == 'p') {
                code += ('<p class="tc-p">' + item.find('textarea').val() + '</p>');
            }
            else if (item.attr('data-type') == 'image') {
                code += '<img class="tcimage" src="' + item.find('img').attr('src') + '" >';
            }
            else if (item.attr('data-type') == 'production') {
                var production = '<div class="item" data-type="production">' + item.html() + '</div>';
                var title = item.find('.tctitle').val();
                var intro = item.find('.tccontent').val();

                //替换 title
                var re = /<label class="form-control inline">(.*?)<\/label>/;
                production = production.replace(re, '<span class="tctitle">' + title + '</span>');
//                console.log(re);

                //替换 介绍
                re = /<label class="form-control" for="introduction">(.*?)<\/label>/;
                production = production.replace(re, '<p class="tccontent">' + intro + '</p>');
//                console.log(production);
                code += production;
            }
        });

        return '<div class="detail">' + code + '</div>';
    }

</script>
</html>
