<body>
    <?php 
    echo $sidebar;
    ?>
	<div id="vi_container" class="container">
		<div id="shade"></div>
		<div id="sbtn" class="sbtn">
			<div class="icon">
				<div class="sidebtn"></div>
			</div>
		</div>
		<div class="homeshowcar">
			<div class="showcartop">
				
			</div>
		</div>
		<div id="vi_content" class="content">
			<div id="vi_main" class="main width-100p">
					123
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