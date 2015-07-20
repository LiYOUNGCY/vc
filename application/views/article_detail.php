<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
	<meta name="format-detection" content="telephone=yes" />
	<meta name="msapplication-tap-highlight" content="no" />
	<script type="text/javascript" src="<?=base_url().'public/'?>js/j162.min.js"></script>
	<link href="<?=base_url().'public/'?>css/common.css" type="text/css" rel="stylesheet" />
	<link href="<?=base_url().'public/'?>css/font-awesome/css/font-awesome.min.css" type="text/css" rel="stylesheet" />
</head>
<body>
	<div id="vc_sidebar" class="sidebar">
		<div class="name">
			<div class="head">
				<a href="#">
					<img src="<?=base_url().'public/'?>img/mm1.jpg" /></a>
			</div>
			<div class="text">
				<a href="#">YOUNGCY</a>
				<div class="identity">
					<span class="icon identity"></span>
				</div>
			</div>
		</div>
		<div class="search">
			<form>
				<input id="" name="" type="text" />
			</form>
			<div>
				<a href="#"> <i class="fa fa-search"></i>
				</a>
			</div>
		</div>
		<div class="menu">
			<ul>
				<li class="menu-list">
					<div class="menu-list-item">
						<a href="dfdfdf">
							<div class="icon">
								<div class="home"></div>
							</div>
							<span class="menu-list-item-text">个人首页</span>
						</a>
					</div>
				</li>
				<a href="asasdas">
					<li class="menu-list active">
						<div class="menu-list-item">
							<div class="icon">
								<div class="guanzhu"></div>
							</div>
							<span class="menu-list-item-text">我的关注</span>
						</div>
					</li>
				</a>
				<li class="menu-list">
					<div class="menu-list-item">
						<a href="#">
							<div class="icon">
								<div class="tongji"></div>
							</div>
							<span class="menu-list-item-text">统计</span>
						</a>
					</div>
				</li>
				<li class="menu-list">
					<div class="menu-list-item">
						<a href="#">
							<div class="icon">
								<div class="sixin"></div>
							</div>
							<span class="menu-list-item-text">私信</span>
						</a>
					</div>
				</li>
				<li class="menu-list">
					<div class="menu-list-item">
						<a href="#">
							<div class="icon">
								<div class="setting"></div>
							</div>
							<span class="menu-list-item-text">设置</span>
						</a>
					</div>
				</li>
				<li class="menu-list">
					<div class="menu-list-item">
						<a href="#">
							<div class="icon">
								<div class="logout"></div>
							</div>
							<span class="menu-list-item-text">退出</span>
						</a>
					</div>
				</li>
			</ul>
		</div>
	</div>
	<div id="vi_container" class="container">
		<div id="shade"></div>
		<div id="sbtn" class="sbtn">
			<div class="icon">
				<div class="sidebtn"></div>
			</div>
		</div>
		<div class="article-container">
			<div class="detail-box">
				<h1><?=$article['title']?></h1>
				<h5><?=$article['subtitle']?></h5>
				<div class="person-box">
					<div class="author">
						<div class="head"><img src="<?=base_url().'public/'?>img/mm1.jpg"></div>
						<div class="status"><div class="icon"><div class="like"></div></div><span><?=$article['like']?></span></div>
					</div>
				</div>
			</div>
			<div class="article-content">
				<?=$article['content']?>
			</div>
			<div class="person-box">
				
			</div>
			<div class="comment clearfix">
				<?php if( empty($comment) ) { ?>
					<div class="empty"></div>
			<?php } else { ?>	
				<ul>
				<?php foreach ($comment as $key => $value) { ?>
				<li class="clearfix">
					<div class="name">
                      <div class="head"><img src="<?=base_url().'public/'?>img/mm1.jpg"><div class="point1"></div></div>
                      <div class="username"><?=$value['user']['name']?></div>
                    </div>
					<div class="de-content">
						<div style="clear:both; visiable:hidden;"></div>
						<div class="text"><?=$value['content']?></div>
						<div class="time"><?=$value['publish_time']?></div>
					</div>
				</li>
				<?php } }?>
				<!-- 
					<li class="clearfix">
					<div class="name me">
                      <div class="head"><img src="<?=base_url().'public/'?>img/mm1.jpg"><div class="point2"></div></div>
                      <div class="username">艺术维C束身衣啊速度和</div>
                    </div>
                    <div class="de-content me">
						<div style="clear:both; visiable:hidden;"></div>
						<div class="text"><?=$value['content']?></div>
						<div class="time"><?=$value['publish_time']?></div>
					</div> 
					</li>
				-->
				</ul>

				<div class="write-comment clearfix">
					<textarea rows="3" cols="40" ></textarea>
				</div>
				<div class="btn">提交</div>
			</div>

		</div>
	</div>
</body>
	<script type="text/javascript" src="<?=base_url().'public/'?>js/vchome.js"></script>
</html>