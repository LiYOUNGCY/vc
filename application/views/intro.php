<body>
    <?php 
    echo $sidebar;
    ?>
	<div id="vi_container" class="container">
		<div id="shade"></div>
		<div id="sbtn" class="sbtn">
			<div class="icon sidebtn"></div>
		</div>
		<div class="homeshowcar">
			<div class="showcartop">
				<div class="user">
					<div class="head">
						<img src="<?php echo $user['pic']; ?>">
					</div>
					<div class="name">
						<?php echo $user['name']; ?>
						<span class="icon identity tooplit">
							<a href=""><div class="i_media"><span>自媒体</span></div></a>
						</span>
					</div>
				</div>
				<div class="intro">
					<span class="text">
						<?php echo $user['intro']; ?>
					</span>
					<a class="link" href="javascript:void(0);"><i class="fa fa-edit"></i></a>
				</div>
				<?php 
					if($me['id'] != $user['id']){
				?>
				<div class="option">
					<div class="gz-btn btn"><i class="fa fa-plus"></i>关注</div>
					<div class="sx-btn btn"><i class="fa fa-envelope"></i>私信</div>
				</div>
				<?php		
					}
				?>
			<div class="home-menu">
				<ul>
					<a href="javascript:void(0);">
						<li>
							<div class="icon home_quanzi"></div>
							圈子
						</li>	
					</a>
					<a href="javascript:void(0);">
						<li class="active">
							<div class="icon home_jieshao"></div>
							介绍
						</li>	
					</a>
					<a href="javascript:void(0);">
						<li>
							<div class="icon home_hezuo"></div>
							合作
						</li>	
					</a>
					<a href="javascript:void(0);">
						<li>
							<div class="icon home_setting"></div>
							设置
						</li>
					</a>
				</ul>
			</div>
			</div>

		</div>
		<div id="vi_content" class="content">
			<div id="vi_main" class="main width-100p">
				<div class="homeintro">
					<div class="title">
						<h1><?php echo $intro['title'] ;?></h1>
					</div>
					<div class="content">
						<?php echo $intro['content'] ;?>
					</div>
					<div class="likeopt">
						
					</div>

				</div>
			</div>
		<div id="vi_footer" class="width-100p">
			<div class="vi_footer">
				<div class="vi_footer_left">
					<div>
						 &nbsp;artvc.cc 京ICP备09025489号-4 
						<a href="#" class="link">用户协议</a>
						 - 
						<a href="#" class="link">隐私政策</a>
						 - 
						<a href="#" class="link">联系我们</a>
						 - 
						<a href="#" class="link">意见反馈</a>
					</div>
					<div class="float-l">
						<a href="#" class="link">
							<i class="fa fa-weibo fa-2x icon"></i>
						</a>
						<a href="#" class="link">
							<i class="fa fa-wechat fa-2x icon"></i>
						</a>
						<a href="#" class="link">
							<i class="fa fa-facebook-official fa-2x icon"></i>
						</a>
					</div>
				</div>
				<div class="vi_footer_right">
					<img src="<?=base_url().'public/'?>img/QRCode.png" /></div>
			</div>
		</div>
		</div>
	</div>
	<script type="text/javascript" src="<?=base_url().'public/'?>js/vchome.js"></script>
</body>
<script type="text/javascript">
	var BASE_URL = $("#BASE_URL").val();
	var GET_FEED_LIST_URL = BASE_URL +"feed/main/get_feed_list"; 
	var PAGE = 1;

	window.onload = function() { 

	}; 
</script>
</html>