<html>
<head>
    <input type="hidden" name="BASE_URL" id="BASE_URL" value="<?php echo base_url();?>">
    <script src="<?php echo base_url()?>public/js/jquery.js"></script>
    <script src="<?php echo base_url()?>public/js/ajaxfileupload.js" type="text/javascript"></script>
</head>

<body>
    <div class="headpic">
        <form action="<?php echo base_url()?>production/publish/publish_production" method="post">
               名称：<input  name="production_name" value="" />
               <input  name="aid" type="hidden" value="1" />
               <input  name="pic" type="hidden" />
               价格：<input  name="price" value="" />         
        </form>
        <div class="box">
            <div class="pic">
                <div id="camera_warp" class="camera_warp">
                    <input type="file" name="upfile" id="upfile" onchange="file_upload()" /> <i class="fa fa-camera fa-5x"></i>
                </div>
                <img id="image" src="" width="400px" height="auto"></div>
            <div class="option">
                <div class="btn cancel">取消</div>
                <div id="save" class="btn save">发布</div>
            </div>
        </div>

    </div>

    <script src="<?php echo base_url()?>public/js/jquery.Jcrop.js" type="text/javascript"></script>
    <script src="<?php echo base_url()?>public/js/jquery.upload.js" type="text/javascript"></script>
    <script type="text/javascript">
var img_src = "";
$(function(){
    $("#image").hide();
    $("form").hide();
    //取消
    $("#cancel").click(function()
    {   
        //重定向
    });

    $("#save").click(function(){
        $('form').submit();
    });
});
function file_upload()
{
    var BASE_URL  = $("#BASE_URL").val();
    var UPLOAD_URL= BASE_URL+'publish/image/upload_production';
    $.ajaxFileUpload({
        url: UPLOAD_URL,
        fileElementId: 'upfile',
        dataType: 'JSON',
        type:'post',
        success: function (data) {
            $("#error_div").html("");
            if(data.error != null)
            {
                $("#error_div").html(data.error);
            }
            else
            {
                var path = data.thumb;
                var pic  = data.pic;
                $("input[name=pic]").val(pic);
                img_src  = path;
                $("#image").attr('src',path);
                $('#image').show();
                $("#camera_warp").hide();      
                // $("form").show();                       
            }

        },
        error: function (data) {
            alert('error');
        }
    });    
}




</script>

</body>
</html>