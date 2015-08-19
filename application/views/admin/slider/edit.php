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
                            轮播编辑
                        </div>
                        <div class="panel-body">
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
					                                    <input class="form-control" name="pic" type="text" value="<?=$slider['pic']?>">
					                                    <input class="form-control" type="file" />
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
<script type="text/javascript">	
	$(function(){
		$("#submit").click(function(){
			$("form").submit();
		});
	});
</script>
</body>
</html>
