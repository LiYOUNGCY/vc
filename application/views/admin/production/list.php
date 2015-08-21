<?php echo $navbar;?>
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">            	
                <div class="col-lg-12"  style="padding:10px 0px;">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            艺术品管理
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">                       
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
										<th>名称</th>
										<th>艺术家</th>
										<th>
											价格
										</th>
										<th>
											状态
										</th>										
										<th>
											收藏量
										</th>
										<th>
											喜欢数
										</th>										
										<th>
											<i class="fa fa-calendar fa-fw"></i>				
											发布时间
										</th>
										<th>
											创建者ID
										</th>	
										<th>
											修改者ID
										</th>
										<th>
											最后修改时间
										</th>																
										<th></th>
									</tr>
								</thead>

								<tbody>
										<?php foreach ($production as $k => $v) {?>
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
													<a href="<?=base_url().'artist/'.$v['aid']?>"><?=$v['artist']?></a>
												</td>
												<td>
													<?=$v['price']?>
												</td>
												<td>
													<?=$status[$v['status']]?>
												</td>												
												<td>
													<?=$v['collection']?>
												</td>
												<td>
													<?=$v['like']?>
												</td>
												<td>
													<?=$v['publish_time']?>
												</td>
												<td>
													<?=$v['creat_by']?>
												</td>	
												<td>
													<?=$v['modify_by']?>
												</td>	
												<td>
													<?=$v['modify_time']?>
												</td>																																																
												<td class="tooltip-btn">
													<button data-toggle="tooltip"  title="查看艺术品" effect="check" u="<?=$v['id']?>" type="button" class="btn btn-success btn-circle"><i class="fa fa-eye"></i>
									                </button>														
													<button data-toggle="tooltip"  title="编辑" effect="edit" u="<?=$v['id']?>" type="button" class="btn btn-success btn-circle"><i class="fa fa-edit"></i>
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
											确认删除所勾选的艺术品?
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
var DELETE_URL= ADMIN+'production/delete_production';
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
			alert('请选择艺术品！');
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

	//查看
	$("button[effect=check]").click(function()
	{
		var pid = $(this).attr('u');	
		if(pid != null && pid != "")
		{
			window.location.href=BASE_URL+'production/'+pid;
		}
	});	
	//编辑
	$("button[effect=edit]").click(function()
	{
		var pid = $(this).attr('u');	
		if(pid != null && pid != "")
		{
			window.location.href=BASE_URL+'update/production/'+pid;
		}
	});
});
</script>
</body>
</html>