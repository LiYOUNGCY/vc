<body>
<div class="main-wrapper">
    <!-- 顶部 -->
<?php echo $top;?>
    <div class="container">
        <div class="content artist">
            <form class="list" method="post" action="<?=base_url()?>artist/publish/publish_artist">
                <div class="item">
                    <label>艺术家的照片：</label>
                    <div class="headpic">
        <!-- <form action="<?php echo base_url()?>publish/image/save_headpic" method="post" onsubmit="return checkCoords();"> -->
            <input type="hidden" id="x" name="x" />
            <input type="hidden" id="y" name="y" />
            <input type="hidden" id="w" name="w" />
            <input type="hidden" id="h" name="h" />
            <input type="hidden" id="img"  name="img" />
        <!-- </form> -->
            <div class="box">
                <div id="camera_warp" class="camera_warp">
                    <input type="file" name="upfile" id="upfile" onchange="file_upload()">
                    <i class="fa fa-camera fa-5x"></i>
                </div>
                <img id="image" src="" width="100%" height="100%">
            </div>
    </div>
                </div>
                <div class="item">
                    <label for="name">艺术家的姓名：</label>
                    <input id="name" name="artist_name" type="text">
                </div>
                <div class="item">
                    <label for="intro">艺术家的简介：</label>
                    <div class="text">
                        <textarea id="intro" name="intro" rows="5"></textarea>
                    </div>
                </div>
                <div class="item">
                    <label for="evaluation">评价：</label>
                    <div class="text">
                        <textarea id="evaluation" name="evaluation" rows="5"></textarea>
                    </div>
                </div>
                <div class="options">
                <div class="btn cancel" onclick="">取消</div>
                <div id="save" class="btn save">保存</div>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
<script src="<?php echo base_url()?>public/js/jquery.Jcrop.js"></script>
    <script src="<?php echo base_url()?>public/js/jquery.upload.js"></script>
<script>
    $(function(){
        autosize($('textarea'));
    });

    var img_src = "";
$(function(){
    $("#image").hide();
    //取消
    $("#cancel").click(function()
    {
        //重定向
    });

    $("#save").click(function(){
        $('form').submit();
    });
});
function jcrop_init(tar)
{
    $(tar).Jcrop({
        bgColor: 'black',
        bgOpacity: 0.4,
        boundary:2,
        setSelect: [100, 100, 300 ,300],  //设定4个角的初始位置
        aspectRatio: 1 / 1,
        onSelect: showCoords   //当选择完成时执行的函数
    });
}
function showCoords(c)
{
    $("#x").val(c.x);
    $("#y").val(c.y);
    $("#w").val(c.w);
    $("#h").val(c.h);
}
//检查裁剪宽度
function checkCoords()
{
    if (parseInt($('#w').val())){
        $("#img").val(img_src);
        return true;
    }
    alert('Please select a crop region then press submit.');
    return false;
}
function file_upload()
{
    var BASE_URL  = $("#BASE_URL").val();
    var UPLOAD_URL= BASE_URL+'publish/image/upload_headpic';
    $.ajaxFileUpload({
        url: UPLOAD_URL,
        fileElementId: 'upfile',
        dataType: 'JSON',
        type:'post',
        success: function (data) {
            // alert(data);
            $("#error_div").html("");
            if(data.error != null)
            {
                $("#error_div").html(data.error);
            }
            else
            {
                var path = data.filepath
                img_src  = path;
                $("#image").attr('src',BASE_URL+path);
                $('#img').attr('value',path);
                $('#image').show();
                $("#camera_warp").hide();
                // $("form").show();
                jcrop_init('#image');
            }

        },
        error: function (data) {
            alert('error');
        }
    });
}
</script>
</script>
</html>
