<body>
    <?php 
    echo $sidebar;
    ?>
	<div id="vi_container" class="container">
		<div id="shade"></div>
		<div class="homeshowcar">
			<div class="showcartop">
				<div class="user">
					<div class="head">
						<img src="<?php echo $user['pic']; ?>">
					</div>
					<div class="name">
						<?=$user['name']; ?>
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
				
				<div class="contact">
					<span><a href="javascript:void(0);" class="link">关注123人</a></span>
					<span><a href="javascript:void(0);" class="link">粉丝23人</a></span>
				</div>

				<div class="home-menu">
					<ul>
						<a href="<?php echo base_url().$user['alias'];?>">
							<li>
								<div class="icon home_quanzi"></div>
								圈子
							</li>	
						</a>
						<a href="<?php echo base_url().$user['alias'].'/intro';?>">
							<li class="active">
								<div class="icon home_jieshao"></div>
								介绍
							</li>	
						</a>
						<a href="<?php echo base_url().'account/setting';?>">
							<li>
								<div class="icon home_setting"></div>
								设置
							</li>	
						</a>
					</ul>
				</div>
			</div>
			<div class="fliter"></div>
		</div>
		<div id="vi_content" class="content">
			<div id="vi_main" class="main width-100p">
				<div class="homeintro">
					<div class="title">
					<?php echo $user['name'];?>的介绍
					</div>
					<hr class="line2" />
					<div class="intro">
						<?php echo $intro['content'] ;?>
					</div>
					<div class="likeopt">
						<div class="likebtn1">
							<div class="support">
								
							</div>
							<div class="num">
								<a href="javascript:void(0);" class="link">12</a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?=$footer?>
		</div>

	</div>
	<script type="text/javascript" src="<?=base_url().'public/'?>js/vchome.js"></script>
</body>
<script type="text/javascript">
	var BASE_URL = $("#BASE_URL").val();
	var GET_FEED_LIST_URL = BASE_URL +"feed/main/get_feed_list"; 
	var PAGE = 1;



	window.onload = function() { 
		$(".likebtn1 .support").click(function(){
			if($(this).parent().hasClass('focus')){
				$(this).parent().attr('class','likebtn1 blur');
			}else{
				$(this).parent().attr('class','likebtn1 focus');
			}
		});

	}; 
</script>
</html>