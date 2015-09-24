<?php echo $navbar;?>
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">            	
                <div class="col-lg-12"  style="padding:10px 0px;">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            用户管理
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs">
                                <li class="active" ><a href="#list" data-toggle="tab" aria-expanded="true">用户列表</a>
                                </li>
                                <li ><a href="#add" data-toggle="tab" aria-expanded="false">添加用户</a>
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
												<th>用户名</th>
												<th>角色</th>
												<th>
													手机
												</th>
												<th>
													邮箱
												</th>
												<th>
													<i class="fa fa-calendar fa-fw"></i>				
													注册时间
												</th>							
												<th>
													<i class="fa fa-calendar fa-fw"></i>
													最后活跃时间
												</th>
												<th>
													状态
												</th>									
												<th></th>
											</tr>
										</thead>

										<tbody>
												<?php foreach ($user as $k => $v) {?>
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
															<?=$v['name']?>
														</td>
														<td>
															<?=$v['role_name']?>
														</td>
														<td>
															<?=$v['phone']?>
														</td>
														<td>
															<?=$v['email']?>
														</td>
														<td>
															<?=$v['register_time']?>
														</td>
														<td>
															<?=$v['last_active']?>
														</td>
														<td>
															<?php if($v['forbidden'] == 0){echo "正常";}else{echo "被封禁";}?>
														</td>											
														<td class="tooltip-btn">
															<button data-toggle="tooltip"  title="编辑" effect="edit" u="<?=$v['id']?>" type="button" class="btn btn-success btn-circle"><i class="fa fa-edit"></i>
											                </button>
															<button data-toggle="tooltip"  title="封禁" effect="forbidden" u="<?=$v['id']?>" type="button" class="btn btn-success btn-circle"><i class="fa fa-ban"></i>
											                </button>								                				
														</td>
													</tr>																					
												<?php }?>
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
													确认删除所勾选的用户?
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

			                        <!--分页-->
			                        <?=$pagination?>	
			                		<!-- /分页-->                                   
                                </div>

                                <!--添加用户-->
                                <div class="tab-pane fade" id="add">
									<table class="table table-striped">
										<form id="add_form" method="post" action="http://127.0.0.1/artvc/admin/user/add_user">
						                    <tbody>
							                    <tr>
							                        <td>
							                            <div class="form-group">
							                                <span class="col-sm-4 col-xs-3 control-label">用户名:</span>
							                                <div class="col-sm-5 col-xs-8">
							                                    <input class="form-control" name="name" type="text" />
							                                </div>
							                            </div>
							                        </td>
							                    </tr>
							                    <tr>
							                        <td>
							                            <div class="form-group">
							                                <span class="col-sm-4 col-xs-3 control-label">邮箱:</span>
							                                <div class="col-sm-5 col-xs-8">
							                                    <input class="form-control" name="email" type="text" value="">
							                                </div>
							                            </div>
							                        </td>
							                    </tr>
							                    <tr>
							                        <td>
							                            <div class="form-group">
							                                <span class="col-sm-4 col-xs-3 control-label">手机:</span>
							                                <div class="col-sm-5 col-xs-8">
							                                    <input class="form-control" name="phone" type="text" value="">
							                                </div>
							                            </div>
							                        </td>
							                    </tr>
								                <tr>
							                        <td>
							                            <div class="form-group">
							                                <span class="col-sm-4 col-xs-3 control-label">密码:</span>
							                                <div class="col-sm-5 col-xs-8">
							                                    <input class="form-control" name="pwd" type="password" value="">
							                                </div>
							                            </div>
							                        </td>
							                    </tr>
												<tr>
							                        <td>
							                            <div class="form-group">
							                                <label class="col-sm-4 col-xs-3 control-label">用户组:</label>
							                                <div class="col-sm-5 col-xs-8">
							                                    <select name="role" class="form-control">
			   														<?php foreach ($role as $k => $v){ ?>
																			<option value="<?=$v['id']?>"><?=$v['name']?></option>
			   														<?php }?>
			                                                    </select>
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
                            	<!--/添加用户-->
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
<script type="text/javascript">
var BASE_URL = $("#BASE_URL").val();
var ADMIN    = $("#ADMIN").val();
var DELETE_URL= ADMIN+'user/delete_user';
var FORBID_URL= ADMIN+'user/forbid_user';
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
			alert('请选择用户！');
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
			$.post(DELETE_URL,{uids:delete_str},function(data)
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
	//封禁
	$("button[effect=forbidden]").click(function()
	{
		var uid = $(this).attr('u');
		if(uid != null && uid != undefined && uid != "")
		{
			$.post(FORBID_URL,{uid:uid},function(data)
			{
				data = eval('('+data+')');
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
			window.location.href=ADMIN+"user/edit/u/"+uid;
		}
	});
	$("#add_submit").click(function(){
		$("#add_form").submit();
	});


});
</script>
</body>
</html>