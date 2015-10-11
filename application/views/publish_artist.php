<body>
<div class="container">
    <div class="main-container">
        <form action="<?= base_url() ?>artist/publish/publish_artist" method="post">
            <input type="hidden" id="x" name="x"/>
            <input type="hidden" id="y" name="y"/>
            <input type="hidden" id="w" name="w"/>
            <input type="hidden" id="h" name="h"/>
            <input type="hidden" id="img" name="img"/>

            <label class="form-control">
                <span>上传艺术家照片</span>
                <label class="button" for="image_upload" style="margin-right: 15px;">
                    上传
                    <input type="file" id="image_upload" name="image_upload" onchange="file_upload()">
                </label>
                <button class="button" type="button" id="preview">编辑照片</button>
                <span class="message danger" id="image_message">艺术家照片还没上传！！</span>
            </label>

            <label class="form-control" for="artist_name">
                <span>艺术家的姓名：</span>
                <input id="artist_name" name="artist_name" type="text">
                <span class="message danger">内容不能为空</span>
            </label>
            <label class="form-control" for="intro">
                <span>艺术家的介绍：</span>
                <textarea id="intro" name="intro" rows='3'></textarea>
                <span class="message danger">内容不能为空</span>
            </label>
            <label class="form-control" for="evaluation">
                <span>维C的评价：</span>
                <textarea id="evaluation" name="evaluation" rows='3'></textarea>
                <span class="message danger">内容不能为空</span>
            </label>

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
            <div class="reveal-title">编辑图片</div>
            <div class="close-box" id="reveal-close"><i class="fa fa-close"></i></div>
        </div>
        <div style="height: 85%; width: 100%; overflow: auto;">
            <img id="image" src="">
        </div>
        <div class="footer">
            <button class="button" type="button" id="close">确定</button>
        </div>
    </div>


</body>
<script src="<?php echo base_url() ?>public/js/jquery.Jcrop.js"></script>
<script src="<?php echo base_url() ?>public/js/jquery.upload.js"></script>
<script>
    var img_src = "";
    $(function () {
        $('#image_message').hide();
        $('.reveal-model').hide();
        $('input').each(function () {
            $(this).blur(function () {
                contentNullEvent(this);
            });
        });

        $('textarea').each(function () {
            autosize(this);
            $(this).blur(function () {
                contentNullEvent(this);
            });
        });

        $('#preview').click(function () {
            fadeInReveal();
        });

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
            if ($('#img').val() == null ||
                $('#img').val() == '') {
                $('#image_message').show();
                submit_status = false;
            }
            else {
                $('#image_message').hide();
            }

            if (submit_status) {
                $('form').submit();
            }
        });

        $('#close').click(function () {
            fadeOutReveal();
        });

        //取消
        $('#back').click(function () {
            window.history.go(-1);
        });

        $("#image").hide();

    });

    function jcrop_init(tar) {
        $(tar).Jcrop({
            bgColor: 'black',
            bgOpacity: 0.4,
            boundary: 2,
            setSelect: [100, 100, 300, 300],  //设定4个角的初始位置
            aspectRatio: 1 / 1,
            onSelect: showCoords   //当选择完成时执行的函数
        });
    }

    function showCoords(c) {
        $("#x").val(c.x);
        $("#y").val(c.y);
        $("#w").val(c.w);
        $("#h").val(c.h);
    }

    //检查裁剪宽度
    function checkCoords() {
        if (parseInt($('#w').val())) {
            $("#img").val(img_src);
            return true;
        }
        alert('Please select a crop region then press submit.');
        return false;
    }

    function file_upload() {
        var BASE_URL = $("#BASE_URL").val();
        var UPLOAD_URL = BASE_URL + 'publish/image/upload_avatar';
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
                    var path = data.path;
                    img_src = path;
                    $("#image").attr('src', BASE_URL + path);
                    $('#image').show();
                    $('#img').attr('value', path);
                    // $("form").show();
                    jcrop_init('#image');
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
                    $('#img').attr('value', path);
                    // $("form").show();
                    jcrop_init('#image');
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
