<div id="vc_sidebar" class="sidebar">
	<div class="name">
		<div class="head">

			<a class="link" href="<?=base_url().$user['alias']?>">
				<img src="<?=$user['pic']?>" />
			</a>
		</div>
		<div class="text">
			<a class="link" href="<?=base_url().$user['alias']?>"><?php echo $user['name'];?></a>
			<div class="icon">
				<span class="identity"></span>
			</div>
		</div>
	</div>
	<div class="menu">
		<ul>
			<a class="link" href="<?=base_url()?>article">
			<li class="menu-list">
				<div class="menu-list-item">
					<div class="icon home"></div>
					<span class="menu-list-item-text">首页</span>
				</div>
			</li>
			</a>
			<?php if($user['role'] == 0) { ?>
			<a class="link" href="<?=base_url()?>login">		
			<li class="menu-list">
				<div class="menu-list-item">
					<div class="icon login"></div>
					<span class="menu-list-item-text">登陆</span>
				</div>
			</li>
			</a>
			<a class="link" href="<?=base_url()?>signup">		
			<li class="menu-list">
				<div class="menu-list-item">
					<div class="icon signup"></div>
					<span class="menu-list-item-text">注册</span>
				</div>
			</li>
			</a>
			<?php }?>
			<?php if($user['role'] != 0) { ?>
			<a class="link" href="<?=base_url()?>notification">		
			<li class="menu-list">
				<div class="menu-list-item">
					<div class="icon sixin"></div>
					<span class="menu-list-item-text">消息</span>
					<span id="notification_num">

					</span>
				</div>
			</li>
			</a>
			<a class="link" href="<?=base_url()?>setting">
			<li class="menu-list">
				<div class="menu-list-item">
					<div class="icon setting"></div>
					<span class="menu-list-item-text">设置</span>
				</div>
			</li>
			</a>
			<?php } ?>
			<a class="link" id="showlang" href="javascript:void(0);">
			<li class="menu-list">
				<div class="menu-list-item">
					<div class="icon language"></div>
					<span class="menu-list-item-text">语言</span>
				</div>
			</li>
			</a>
			<div class="lop" id="lop">
				<div id="lop-zh" style="border-right: 1px solid #4C4640;" class="btn">简体中文</div>
				<div id="lop-en" class="btn">English</div>
			</div>
			<?php if($user['role'] != 0) { ?>
			<a class="link" href="<?=base_url()?>account/main/logout">
			<li class="menu-list">
				<div class="menu-list-item">
					<div class="icon logout"></div>
					<span class="menu-list-item-text">退出</span>
				</div>
			</li>
			</a>
			<?php } ?>
		</ul>
	</div>
	<?php
		$push_id = NULL; 
		if(isset($user['id']))
		{
			$push_id = md5(md5('artvc'.$user['id']));
		}
	?>
	<input type="hidden" id="PUSH_ID" value="<?=$push_id?>" />	
	<script type="text/javascript">
	$(function(){
	  var count = getcookie('push_msg');
	  if(count != null && count != "" && count != undefined)
	  {
	  	$("dot").show();
	  	$("#notification_num").empty().html('<div class="numtooplit">'+count+'</div>');
	  }

	  var push_id = $("#PUSH_ID").val();
	  if(push_id != null && push_id != "" && push_id != undefined)
	  {
		  var yunba = new Yunba({
		    server: 'sock.yunba.io', port: 3000, appkey: '55bc441c14ec0a7d21a70c5a'});
	  
		  yunba.init(function (success) {
		    if (success) {
		      yunba.connect_by_customid(push_id, function (success, msg) {
		        if(success)
		          {

		              yunba.subscribe({'topic': push_id});  

		              
		              yunba.set_message_cb (function (data) {
		              	alert(data);
		              	  var count = getcookie('push_msg');
		                  if(count != null && count != "" && count != undefined)
		                  {
		                  	count = parseInt(count)+1;
		                  }
		                  else
		                  {
		                  	count = 1;
		                  }
		                  setcookie('push_msg',count);
					  	  $("dot").show();
	  					  $("#notification_num").empty().html('<div class="numtooplit">'+count+'</div>');
		              });          
		          }
		      });
		    }
		  });  	  
	  }
	});

	</script>	
</div>
<div id="sbtn" class="sbtn">
	<div class="icon sidebtn"></div>
	<div class="dot" id="notification_dot"></div>
</div>