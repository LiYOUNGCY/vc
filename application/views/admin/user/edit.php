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
                            用户编辑
                        </div>
                        <div class="panel-body">
							<table class="table table-striped">
								<form method="post" action="<?=base_url().ADMINROUTE.'user/update_user'?>">
				                	<input name="uid" type="hidden" value="<?=$user['id']?>">
				                    <tbody>
					                    <tr>
					                        <td>
					                            <div class="form-group">
					                                <span class="col-sm-4 col-xs-3 control-label">用户名:</span>
					                                <div class="col-sm-5 col-xs-8">
					                                    <input class="form-control" name="name" type="text" value="<?=$user['name']?>">
					                                </div>
					                            </div>
					                        </td>
					                    </tr>
					                    <tr>
					                        <td>
					                            <div class="form-group">
					                                <span class="col-sm-4 col-xs-3 control-label">邮箱:</span>
					                                <div class="col-sm-5 col-xs-8">
					                                    <input class="form-control" name="email" type="text" value="<?=$user['email']?>">
					                                </div>
					                            </div>
					                        </td>
					                    </tr>
					                    <tr>
					                        <td>
					                            <div class="form-group">
					                                <span class="col-sm-4 col-xs-3 control-label">手机:</span>
					                                <div class="col-sm-5 col-xs-8">
					                                    <input class="form-control" name="phone" type="text" value="<?=$user['phone']?>">
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
	   															 <?php if($user['role'] == $v['id']){?>
																	<option value="<?=$v['id']?>" selected><?=$v['name']?></option>
	   															 <?php } else{?>
	   															 <option value="<?=$v['id']?>"><?=$v['name']?></option>
	   															<?php }?>
	   														<?php }?>
	                                                    </select>
					                                </div>
					                            </div>
					                        </td>
					                    </tr>
										<tr>
					                        <td>
					                            <div class="form-group">
					                                <span class="col-sm-4 col-xs-3 control-label">头像:</span>
						                                <div class="col-sm-2">
						                                    <p>
						                                        <img src="<?=$user['pic']?>" alt="" style="border-radius:50px;width:100px;height:100px;" class="img-polaroid">
						                                    </p>
						                                    <span class="mod-file">
						                                        <input type="file" name="pic" exts="png|jpg|jpeg" class="mod-input-file" value="点击更换头像">
						                                    </span>
						                                    <br>
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
					                                    <span class="help-block">不更改请留空</span>
					                                </div>
					                            </div>
					                        </td>
					                    </tr>
										<tr>
					                        <td>
					                            <div class="form-group">
					                                <span class="col-sm-4 col-xs-3 control-label">禁用:</span>
					                                <div class="col-sm-8 col-xs-8">

			                                            <label class="radio-inline">
			                                                <input type="radio" name="forbidden" id="optionsRadiosInline1" value="0" <?php if($user['forbidden'] == 0){echo "checked";}?>>否
			                                            </label>
			                                            <label class="radio-inline">
			                                                <input type="radio" name="forbidden" id="optionsRadiosInline2" value="1" <?php if($user['forbidden'] == 1){echo "checked";}?>>是
			                                            </label>												
					                                </div>
					                            </div>
					                        </td>
					                    </tr>									                  				                    
										<tr>
					                        <td>
					                            <div class="form-group">
					                                <span class="col-sm-4 col-xs-3 control-label">注册时间:</span>
					                                <div class="col-sm-6 col-xs-8">
					                                    <div class="btn-group mod-btn">
					                                        <?=$user['register_time']?>
					                                    </div>
					                                </div>
					                            </div>
					                        </td>
					                    </tr>
										<tr>
					                        <td>
					                            <div class="form-group">
					                                <span class="col-sm-4 col-xs-3 control-label">最后活跃时间:</span>
					                                <div class="col-sm-6 col-xs-8">
					                                    <div class="btn-group mod-btn">
					                                        <?=$user['last_active']?>
					                                    </div>
					                                </div>
					                            </div>
					                        </td>
					                    </tr>
										<tr>
					                        <td>
					                            <div class="form-group">
					                                <span class="col-sm-4 col-xs-3 control-label">ip:</span>
					                                <div class="col-sm-6 col-xs-8">
					                                    <div class="btn-group mod-btn">
					                                        <?=$user['ip']?>
					                                    </div>
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
	});
</script>
</body>
</html>
