<?php
	echo $navbar;
?>
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">

                    <div class="panel panel-primary" style="margin-top:20px;">
                        <div class="panel-heading">
                            权限编辑
                        </div>
                        <div class="panel-body">
							<table class="table table-striped">
								<form id="form" method="post" action="<?=base_url()?>admin/user/update_auth">
				                	<input name="id" type="hidden" value="<?=$auth['id']?>">
				                    <tbody>
					                    <tr>
					                        <td>
					                            <div class="form-group">
					                                <span class="col-sm-4 col-xs-3 control-label">权限名:</span>
					                                <div class="col-sm-5 col-xs-8">
					                                    <input class="form-control" name="name" type="text" value="<?=$auth['name']?>"/>
					                                </div>
					                            </div>
					                        </td>
					                    </tr>
					                    <tr>
					                        <td>
					                            <div class="form-group">
					                                <span class="col-sm-4 col-xs-3 control-label">路由:</span>
					                                <div class="col-sm-5 col-xs-8">
					                                    <input class="form-control" name="route" type="text" value="<?=$auth['route']?>" />
					                                </div>
					                            </div>
					                        </td>
					                    </tr>
					                    <tr>
					                        <td>
					                            <div class="form-group">
					                                <span class="col-sm-4 col-xs-3 control-label">角色组:</span>
					                                <div class="col-sm-5 col-xs-8">
					                                	<?php
					                                		$arr = explode(',',$auth['role_group']);
															$str = "";
															foreach ($arr as $k1 => $v1) {
																for($i = 0; $i < count($role); $i++)
																{
																	if($v1 == "|{$role[$i]['id']}|")
																	{
																		$str.=$role[$i]['name'].",";
																		break;
																	}
																}
															}
															if( ! empty($str))
															{
																$str = substr($str,0,strlen($str)-1);
															}
					                                	?>
					                                    <input class="form-control" id="show_role"  type="text" value="<?=$str?>" disabled="disabled">
					                                </div>

													<button type="button" id="clear_group" class="btn btn-warning btn-circle"><i class="fa fa-times"></i></button>
				                                    <input type="hidden" name="role_group" id="role_group" value="<?=$auth['role_group']?>"/>
				                                    <div class="col-sm-2 col-xs-8">
					                                    <select name="group_select" class="form-control">
					                                    	<option value="" ></option>
	   														<?php foreach ($role as $k => $v){ ?>
																	<option value="|<?=$v['id']?>|">
																		<?=$v['name']?>
																	</option>
	   														<?php }?>
	                                                    </select>
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
<script type="text/javascript">
	$(function(){
		$("#submit").click(function(){
			$("form").submit();
		});
		//权限编辑下拉列表
		$("select[name=group_select]").change(function(){
			var op_html = $("option:selected").html();
			var op_val  = $("option:selected").val();
			var group_val = $("input[name=role_group]").val();
			if(group_val.indexOf(op_val,0) == -1)
			{
				op_html = op_html.replace(/^\s+|\s+$/g,"");
				var old_html = $("#show_role").val() == "" ? "" : $("#show_role").val()+",";
				$("#show_role").val(old_html+op_html);
				var old_val  = $("input[name=role_group]").val() == "" ? "" : $("input[name=role_group]").val()+",";
				$("input[name=role_group]").val(old_val+op_val);
			}

		});
		$("#clear_group").click(function(){
			$("#show_role").val("");
			$("input[name=role_group]").val("");
		});
	});


</script>
</body>
</html>
