<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">请登录</h3>
                </div>
                <div class="panel-body">
                    <form role="form" method="post" action="<?=base_url().ADMINROUTE?>login/login_action">
                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" placeholder="用户名" name="email" type="email" autofocus>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="密码" name="pwd" type="password" value="">
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input name="rememberme" type="checkbox" value="记住密码">Remember Me
                                </label>
                            </div>
                            <a href="javascript:void(0);" id="submit" class="btn btn-lg btn-success btn-block">Login</a>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
 
<?php 
	echo $foot;
?>
<script type="text/javascript">
	$(function(){
		$("#submit").click(function(){
			$("form").submit();
		})
	});
</script>
</body>
</html>