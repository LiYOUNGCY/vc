<?php 
	echo $navbar;
?>
<style>

#bscreen{
    width: 100%;
    height: 100%;
    position: fixed;
    background: #000;
    opacity: 0.8;
    left: 0;
    top: 0;
    z-index: 10000;
    display: none;
}

#bigthum{
    width: 960px;
    height: 470px;
    padding: 0px;
    position: fixed;
    background: #fff;
    display: none; 
    z-index: 100000;
    box-shadow: #fff 0 0 25px;
}
</style>
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">

                    <div class="panel panel-primary" style="margin-top:20px;">
                        <div class="panel-heading">
                            轮播编辑
                        </div>
                        <div class="panel-body">
                        	<div id="bscreen"></div>
                        	<div id="bigthum"></div>            	
							<table class="table table-striped">
								<form method="post" action="<?=base_url().ADMINROUTE.'slider/update_slider'?>">
				                	<input name="id" type="hidden" value="<?=$slider['id']?>">
				                    <tbody>
					                    <tr>
					                        <td>
					                            <div class="form-group">
					                                <span class="col-sm-4 col-xs-3 control-label">轮播标题:</span>
					                                <div class="col-sm-5 col-xs-8">
					                                    <input class="form-control" name="slider_title" type="text" value="<?=$slider['title']?>">
					                                </div>
					                            </div>
					                        </td>
					                    </tr>
					                    <tr>
					                        <td>
					                            <div class="form-group">
					                                <span class="col-sm-4 col-xs-3 control-label">轮播图片:</span>
					                                <div class="col-sm-5 col-xs-8">
       													<input class="form-control" style="float:left;width:85%;" name="pic" value="<?=$slider['pic']?>" type="text"/>
					                                	<button type="button" id="check_newpic" style="float:left;" class="btn btn-outline btn-primary">预览</button>
			                                			<input type="file" name="upfile" id="upfile" style="float:left;" onchange="file_upload()">
					                                </div>
					                            </div>
					                        </td>
					                    </tr>
					                    <tr>
					                        <td>
					                            <div class="form-group">
					                                <span class="col-sm-4 col-xs-3 control-label">链接地址:</span>
					                                <div class="col-sm-5 col-xs-8">
					                                    <input class="form-control" name="href" type="text" value="<?=$slider['href']?>">
					                                </div>
					                            </div>
					                        </td>
					                    </tr>										               				                    				                    
				                	</tbody>
				                </form>
			            	</table>
                        </div>
                        <div class="panel-footer">
                        	<center>
								<button id="submit" type="button" class="btn btn-outline btn-primary">保存设置</button>
                        	</center>
                        </div>
                    </div>
	                	                
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->
 

<?php 
    echo $foot;
?>
<script src="<?=base_url()?>public/js/ajaxfileupload.js"></script>
<script type="text/javascript">	
	$(function(){
		$("#submit").click(function(){
			$("form").submit();
		});
		$("#check_newpic").click(function(){
			var pic = $('input[name=pic]').val();
			if(pic != null && pic != undefined && pic != "")
			{
				$("#bigthum").append('<img width="960px" height="470px" src="'+pic+'" />');
				$("#bscreen").show();			
				$("#bigthum").show();			
			}
		});	
		$("#bigthum").click(function(){
			$("#bigthum").hide();		
			$("#bigthum").empty();
			$("#bscreen").hide();
		});
		$("#bscreen").click(function(){
			$("#bigthum").hide();		
			$("#bigthum").empty();
			$("#bscreen").hide();		
		});			
	});
	function file_upload()
	{
	    var BASE_URL  = $("#BASE_URL").val();
	    var UPLOAD_URL= BASE_URL+'publish/image/upload_slider';
	    $.ajaxFileUpload({
	        url: UPLOAD_URL,
	        fileElementId: 'upfile',
	        dataType: 'JSON',
	        type:'post',
	        success: function (data) {
	            if(data.error != null)
	            {
					$(".alert-danger").html(data.error);
					$(".alert-danger").fadeIn(1000,function(){
						$(this).fadeOut();	
					});
	            }
	            else
	            {
					$(".alert-success").html('上传成功');
					$(".alert-success").fadeIn(1000,function(){
						$(this).fadeOut();						
					});
	                var path = data.pic;
	                $('input[name=pic]').attr('value',path);
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
