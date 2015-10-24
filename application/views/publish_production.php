<?php
load_header(
    '发布艺术品',
    'font-awesome/css/font-awesome.min.css',
    'edit_style.css',
    'alert.css',
    'easydropdown.css'
)
?>

<body>
<div class="main-container">
    <h2>发布艺术品</h2>

    <form action="<?= base_url() ?>production/publish/publish_production" method="post">
        <input type="hidden" id="image_id" name="image_id"/>

        <label class="form-control">
            <span>上传艺术品照片</span>
            <label class="button" for="image_upload" style="margin-right: 15px;">
                <span>上传</span>
                <input type="file" id="image_upload" name="image_upload" onchange="file_upload()">
            </label>
            <button class="button" type="button" id="preview">查看照片</button>
            <span class="message danger" id="image_message">艺术品图片还没上传！！</span>
        </label>

        <label class="form-control" for="name">
            <span>艺术品的标题：</span>
            <input id="name" name="name" type="text">
            <span class="message danger">内容不能为空</span>
        </label>

        <label class="form-control" for="intro">
            <span>艺术品的介绍：</span>
            <textarea id="intro" name="intro" rows='3'></textarea>
            <span class="message danger">内容不能为空</span>
        </label>

        <label class="form-control">
            <span>作者：</span>
            <input type="hidden" id="aid" name="aid" value="">
            <button class="button" type="button" id="choose_author">选择</button>
            <span class="message danger" id="author_message">请选择作者！！</span>
        </label>

        <div class="clearfix" style="padding-top: 1rem;">
            <label for="medium" style="float:left;">艺术门类：</label>
            <select class="dropdown" id="medium" name="medium">
                <?php foreach ($medium as $key => $value) {
    ?>
                    <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                <?php 
} ?>
            </select>
        </div>

        <div class="clearfix" style="padding-top: 1rem;">
            <label for="style" style="float: left;">风格：</label>
            <select class="dropdown" id="style" name="style">
                <?php foreach ($style as $key => $value) {
    ?>
                    <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                <?php 
} ?>
            </select>
        </div>

        <label class="form-control" for="l">
            <span>长（CM 厘米）：</span>
            <input id="l" name="l" type="text">
            <span class="message danger">内容不能为空</span>
        </label>

        <label class="form-control" for="w">
            <span>宽（CM 厘米）：</span>
            <input id="w" name="w" type="text">
            <span class="message danger">内容不能为空</span>
        </label>

        <label class="form-control" for="h">
            <span>高（CM 厘米）：</span>
            <input id="h" name="h" type="text">
            <span class="message danger">内容不能为空</span>
        </label>

        <label class="form-control" for="price">
            <span>价格（元）：</span>
            <input id="price" name="price" type="text">
            <span class="message danger">内容不能为空</span>
        </label>

        <label class="form-control" for="creat_time">
            <span>创作日期：（无规定格式，可数字，可中文）</span>
            <input id="creat_time" name="creat_time" type="text">
            <span class="message danger">内容不能为空</span>
        </label>

        <label for="" class="form-control">
            <p>选择裱：</p>
        </label>
        <?php foreach ($frame as $key => $value) {
    ?>
            <label class="form-control inline" style="width: auto;">
                <?= $value['name'] ?>
                <input type="checkbox" name="frame_list[]" value="<?= $value['id'] ?>" >
            </label>
        <?php 
} ?>

        <div class="option form-control">
            <button type="button" class="button cancel" id="back">返回</button>
            <button type="button" class="button success" id="save">保存</button>
        </div>
    </form>
</div>

<!-- Reveal Model -->
<div class="reveal-model-bg" id="reveal"></div>
<div class="reveal-model">
    <div class="top">
        <div class="reveal-title">查看图片</div>
        <div class="close-box" id="reveal-close"><i class="fa fa-close"></i></div>
    </div>
    <div class="wrap" id="reveal-content">
    </div>
    <div></div>
</div>


</body>
<script src="<?= base_url() ?>public/js/jquery.js"></script>
<script src="<?= base_url() ?>public/js/autosize.js"></script>
<script src="<?= base_url() ?>public/js/ajaxfileupload.js"></script>
<script src="<?= base_url() ?>public/js/alert.min.js"></script>
<script src="<?= base_url() ?>public/js/jquery.easydropdown.js"></script>
<script>
    var img_src = '';
    var page = 0;
    $(function () {
        $('#image_message').hide();
        $('#author_message').hide();

        $('#preview').click(function () {
            fadeInReveal();

            $('#reveal-content').html('<img id="image" src="' + img_src + '">');
        });

        //保存
        $('#save').click(function () {
            var submit_status = true;
            //检查表单的内容，不能为空
            $('label > input[type="text"]').each(function () {
                if (!contentNullEvent(this)) {
                    submit_status = false;
                }
            });

            $('textarea').each(function () {
                if (!contentNullEvent(this)) {
                    submit_status = false;
                }

            });
            if ($('#image_id').val() == null ||
                $('#image_id').val() == '') {
                $('#image_message').show();
                submit_status = false;
            }
            else {
                $('#image_message').hide();
            }

            if ($('#aid').val() == null ||
                $('#aid').val() == '') {
                $('#author_message').show();
                submit_status = false;
            }
            else {
                $('#author_message').hide();
            }

            if (submit_status) {
                $('form').submit();
            }
        });


        $('#back').click(function () {
            window.history.go(-1);
        });

        //选择作者
        $('#choose_author').click(function () {
            page = 0;
            var $container = $('#reveal-content');
            var $load_more = $('<button type="button" class="button">加载更多</butto>');
            $container.html('');
            $container.append($load_more);
            $load_more.click(function () {
                get_author($container);
            });
            get_author($container);
            fadeInReveal();
        });

    });

    function file_upload() {
        var BASE_URL = $("#BASE_URL").val();
        var UPLOAD_URL = BASE_URL + 'publish/image/upload_image';
        $.ajaxFileUpload({
            url: UPLOAD_URL,
            fileElementId: 'image_upload',
            dataType: 'JSON',
            type: 'post',
            success: function (data) {
                console.log(data);
                if (data.error == 0) {
                    console.log('Error');
                }
                else {
                    var path = data.oss_path;
                    console.log('path:' + path);
                    img_src = path;
                    //获取图片的id
                    $('#image_id').val(data.image_id);
                    //获取图片的路径
                    $("#image").attr('src', path);
                    $('#image').show();
                    // $("form").show();
                }
            },
            error: function (data) {
                if (data.error == 0) {
                    console.log('Error');
                }
                else {
                    var path = data.path;
                    img_src = path;
                    $("#image").attr('src', BASE_URL + path);
                    $('#image').show();
                    // $("form").show();
                }
            }
        });
    }

    function get_author($container) {
        console.log('adsf');
        $.ajax({
            url: BASE_URL + 'artist/main/get_artist_list',
            type: 'post',
            data: {
                page: page
            },
            async: false,
            dataType: 'json',
            success: function (data) {
                console.log(data);

                if (data.error != null || data.length == 0) {
                    $container.append('<span>没有更多了</span>');
                    console.log('Cannot read the artist');
                    return false;
                }

                page++;
                for (var i = 0; i < data.length; i++) {
                    var item = data[i];
                    var name = item.name;
                    var pic = item.pic;
                    var id = item.id;

                    $box = $('<div class="avatar" data-id="' + id + '">' +
                        '<img src="' + pic + '">' +
                        '<span>' + name + '</span>' +
                        '</div>');

                    //add click event
                    $box.click(function () {
                        var id = $(this).attr('data-id');
                        console.log(id);
                        $('#aid').val(id);
                        fadeOutReveal();
                    });

                    $container.append($box);
                }
            }
        });
    }


    /**
     * 打开弹出层
     */
    function fadeInReveal() {
        var reveal = $('.reveal-model-bg');

        if (!reveal.hasClass('open')) {
            reveal.addClass('open');
            $('.reveal-model-bg').click(fadeOutReveal);
            $('#reveal-close').click(fadeOutReveal);
            $('.reveal-model').show();
        }
    }


    /**
     * 关闭弹出层
     */
    function fadeOutReveal() {
        var reveal = $('.reveal-model-bg');

        if (reveal.hasClass('open')) {
            reveal.removeClass('open');
            $('.container').css('zIndex', 9999);
            $('.reveal-model').hide();
        }
    }

    /**
     * 判断输入框里的内容是否为空
     * @returns {boolean}
     */
    function contentNullEvent(self) {
        var content = trim(content = $(self).val());
        var alert = $(self).next();

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
</script>
</html>
