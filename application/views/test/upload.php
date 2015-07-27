<html>
<head>
<input type="hidden" name="BASE_URL" id="BASE_URL" value="<?php echo base_url();?>" />
<link href="<?php echo base_url()?>public/css/jquery.Jcrop.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url()?>public/js/jquery.js"></script>
<script src="<?php echo base_url()?>public/js/ajaxfileupload.js" type="text/javascript"></script>
</head>
<body>
<img src="" id="img_div" style="width:400px;height:400px;"/>
<input type="file" name="upfile" id="upfile" onchange="file_upload()" />  
<div class="error_div"></div>
<form action="<?php echo base_url()?>publish/image/save_headpic" method="post" onsubmit="return checkCoords();">  
            <input type="hidden" id="x" name="x" />  
            <input type="hidden" id="y" name="y" />  
            <input type="hidden" id="w" name="w" />  
            <input type="hidden" id="h" name="h" />
            <input type="hidden" id="img"  name="img" />
            <input type="button" id="cancel" value="取消"/>
            <input type="submit" value="裁剪" />  
</form>
<script src="<?php echo base_url()?>public/js/jquery.Jcrop.js" type="text/javascript"></script>

<script type="text/javascript">
var img_src = "";
$(function(){
    $("form").hide();
    //取消
    $("#cancel").click(function()
    {   
        //重定向
    });
});
function jcrop_init()
{
    $('#img_div').Jcrop({
        bgColor: 'black',
        bgOpacity: 0.4,
        boundary:2,
        setSelect: [100, 100, 150,150],  //设定4个角的初始位置
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
        secureuri: false,
        fileElementId: 'upfile',
        dataType: 'json',
        success: function (data) {

            $("#error_div").html("");
            if(data.error != null)
            {
                $("#error_div").html(data.error);
            }
            else
            {
                var path = data.filepath
                img_src  = path;
                $("#img_div").attr('src',BASE_URL+path);
                $("#upfile").hide();      
                $("form").show();                      
                jcrop_init();   
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