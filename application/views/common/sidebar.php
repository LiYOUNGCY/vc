<div id="vc_sidebar" class="sidebar">
	<div class="name">
		<div class="head">
			<a class="link" href="<?=$user['alias']?>">
				<img src="<?=$user['pic']?>" />
			</a>
		</div>
		<div class="text">
			<a class="link" href="<?=$user['alias']?>"><?php echo $user['name'];?></a>
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
			<a class="link" href="<?=base_url()?>notification/conversation">		
			<li class="menu-list">
				<div class="menu-list-item">
					<div class="icon sixin"></div>
					<span class="menu-list-item-text">消息</span>
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
</div>