<?php echo $navbar;?>
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
                <div class="col-lg-12"  style="padding:10px 0px;">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            轮播管理
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                        	<div id="bscreen"></div>
                        	<div id="bigthum"></div>
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs">
                                <li class="active" ><a href="#list" data-toggle="tab" aria-expanded="true">轮播列表</a>
                                </li>
                                <li ><a href="#add" data-toggle="tab" aria-expanded="false">添加轮播</a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content" style="padding:10px 0px 0px 0px;">
                                <div class="tab-pane fade active in" id="list">
			 						<!--表格-->
									<table id="sample-table-1" style="font-family:'Open Sans';" class="table table-striped table-bordered table-hover">
										<thead>
											<tr>
												<th class="center">
													<label>
														<input type="checkbox" class="ace" id="all_check">
														<span class="lbl"></span>
													</label>
												</th>
												<th>ID</th>
												<th>轮播标题</th>
												<th>创建者ID</th>
												<th>
													<i class="fa fa-calendar fa-fw"></i>														
													创建时间
												</th>

												<th>
													修改者ID
												</th>
												<th>
													<i class="fa fa-calendar fa-fw"></i>				
													最后修改时间
												</th>															
												<th></th>
											</tr>
										</thead>

										<tbody>
												<?php foreach ($slider as $k => $v) {
    ?>
													<tr class="selected">
														<td class="center">
															<label>
																<input u="<?=$v['id']?>" type="checkbox" class="ace" tag="child_check">
																<span class="lbl"></span>
															</label>
														</td>			
														<td>
															<?=$v['id']?>
														</td>				
														<td>
															<?=$v['title']?>
														</td>
														<td>
															<?=$v['creat_by']?>
														</td>
														<td>
															<?=$v['creat_time']?>
														</td>
														<td>
															<?=$v['modify_by']?>
														</td>
														<td>
															<?=$v['modify_time']?>
														</td>
										
														<td class="tooltip-btn">
															<button data-toggle="tooltip"  title="预览" effect="check" u="<?=$v['pic']?>" type="button" class="btn btn-success btn-circle"><i class="fa fa-eye"></i>
											                </button>
															<button data-toggle="tooltip"  title="编辑" effect="edit" u="<?=$v['id']?>" type="button" class="btn btn-success btn-circle"><i class="fa fa-edit"></i>
											                </button>								                				
														</td>
													</tr>																					
												<?php 
}?>
										</tbody>
									</table>
			                        <!-- /表格-->
									<button  id="delete"  type="button" class="btn btn-outline btn-danger">删除</button>
				                     <input id="modal_open" type="hidden" data-toggle="modal" data-target="#myModal"  />
				                        <!-- Modal -->
				                        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				                            <div class="modal-dialog">
				                                <div class="modal-content">
				                                    <div class="modal-header">
				                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				                                        <h4 class="modal-title" id="myModalLabel">删除提示</h4>
				                                    </div>
				                                    <div class="modal-body">
													确认删除所勾选的轮播?
				                                    </div>
				                                    <div class="modal-footer">
				                                        <button type="button" class="btn btn-default" id="close_modal" data-dismiss="modal">Close</button>
				                                        <button type="button" id="delete_confirm" class="btn btn-primary">确认</button>
				                                    </div>
				                                </div>
				                                <!-- /.modal-content -->
				                            </div>
				                            <!-- /.modal-dialog -->
				                        </div>
				                        <!-- /.modal -->                                 
                                </div>

                                <!--添加轮播-->
                                <div class="tab-pane fade" id="add">
									<table class="table table-striped">
										<form id="add_form" method="post" action="http://127.0.0.1/artvc/admin/slider/add_slider">
						                    <tbody>
							                    <tr>
							                        <td>
							                            <div class="form-group">
							                                <span class="col-sm-4 col-xs-3 control-label">轮播标题:</span>
							                                <div class="col-sm-5 col-xs-8">
							                                    <input class="form-control" name="slider_title" type="text" />
							                                </div>
							                            </div>
							                        </td>
							                    </tr>
							                    <tr>
							                        <td>
							                            <div class="form-group">
							                                <span class="col-sm-4 col-xs-3 control-label">轮播图片:</span>
							                                <div class="col-sm-5 col-xs-8">
							                                	<input class="form-control" style="float:left;width:85%;" name="pic" type="text"/>
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
							                                    <input class="form-control" name="href" type="text" value="">
							                                </div>
							                            </div>
							                        </td>
							                    </tr>                  				                    				                    
											</tbody>
										</form>
									</table>   
		                        	<div class="panel-footer">
			                        	<center>
											<button id="add_submit" type="button" class="btn btn-outline btn-primary">提交</button>
			                        	</center>
	                        		</div>
                                </div>
                            	<!--/添加轮播-->
                            </div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->    

                       

                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->

<?php echo $foot;?>
<script src="<?=base_url()?>public/js/ajaxfileupload.js"></script>
<script type="text/javascript">
var BASE_URL = $("#BASE_URL").val();
var ADMIN    = $("#ADMIN").val();
var DELETE_URL= ADMIN+'slider/delete_slider';
$(function()
{
    $('.tooltip-btn').tooltip({
        selector: "[data-toggle=tooltip]",
        container: "body"
    })

	$("#all_check").click(function()
	{
		var child = $("input[tag=child_check]");
		if(child.prop('checked') == true)
		{
			child.prop("checked",false);			
		}
		else
		{
			child.prop("checked",true);			
		}

	});
	
	//删除按钮事件
	$("#delete").click(function(){
		var child = $("input[tag=child_check]:checked");
		if(child.length != 0)
		{
			$("#modal_open").click();			
		}
		else{
			alert('请选择轮播！');
			return false;
		}
	});	

	//确认删除
	$("#delete_confirm").click(function(){
		var delete_str = "";
		var child = $("input[tag=child_check]:checked");
		child.each(function()
		{
			var uid = $(this).attr('u');
			if(uid != null && uid != undefined && uid != "")
			{
				delete_str += uid+",";		
			}
		});
		if(delete_str != "")
		{
			delete_str = delete_str.substr(0,delete_str.length-1);
			$.post(DELETE_URL,{aids:delete_str},function(data)
			{
				data = eval('('+data+')');
				$("#close_modal").click();
				if(data.error != null)
				{
					$(".alert-danger").append(data.error);
					$(".alert-danger").fadeIn(1000,function(){
						$(this).fadeOut();
						if(data.script != "")
						{
							eval(data.script);							
						}
	
					});
				}	
				else if(data.success == 0)
				{ 
					$(".alert-success").append(data.note);
					$(".alert-success").fadeIn(1000,function(){
						$(this).fadeOut();	
						eval(data.script);								
					});
				}
			});
		}
	});

	//编辑
	$("button[effect=edit]").click(function()
	{
		var uid = $(this).attr('u');	
		if(uid != null && uid != "")
		{
			window.location.href=ADMIN+"slider/edit/"+uid;
		}
	});
	//预览
	$("button[effect=check]").click(function()
	{
		var pic = $(this).attr('u');	
		if(pic != null && pic != "")
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
	$("#add_submit").click(function(){
		$("#add_form").submit();
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