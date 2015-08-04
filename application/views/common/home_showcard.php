<!-- 头像的编辑框 -->
<div id="headpic" class="headpic hidden" style="z-index:10007;">
	<form action="<?php echo base_url()?>publish/image/save_headpic" method="post" onsubmit="return checkCoords();">
	    <input type="hidden" id="x" name="x" />
	    <input type="hidden" id="y" name="y" />
	    <input type="hidden" id="w" name="w" />
	    <input type="hidden" id="h" name="h" />
	    <input type="hidden" id="img"  name="img" />
	</form>
	<div class="box">
	    <div class="pic">
	        <div id="camera_warp" class="camera_warp">
	            <input type="file" name="upfile" id="upfile" onchange="file_upload()" /> <i class="fa fa-camera fa-5x"></i>
	            <p style="color:#CCC;">点击修改头像</p>
	        </div>
	        <img id="image" src="" width="400px" height="400px"></div>
	    <div class="option">
	        <div id="cancel" class="btn cancel">取消</div>
	        <div id="save" class="btn save">发布</div>
	    </div>
	</div>
</div>
<!-- END 头像的编辑框 -->
<div class="homeshowcar">
	<div class="showcartop">
		<div class="user">
			<div id="head" class="head">
				<img src="<?php echo $people['pic']; ?>">
				<div id="shadow" class="shadow">
					<i class="fa fa-camera"></i>
				</div>
			</div>
			<div class="name">
				<?=$people['name']; ?>
				<?php
					if($people['role'] == 2){
				?>
				<span class="icon identity tooplit">
					<a href=""><div class="i_media"><span>自媒体</span></div></a>
				</span>
				<?php  
					}
				?>
			</div>
			<input type="hidden" value="<?=$people['id']?>" id="peopleid" />
		</div>
		<div class="intro">
			<span class="text">
				<?php echo $people['intro']; ?>
			</span>
			<a class="link" href="javascript:void(0);"><i class="fa fa-edit"></i></a>
		</div>
		<?php 
			if(!isset($user['id']) || $user['id'] != $people['id']){
		?>
		<div class="option">
			<?php
				if(empty($people['follow_status']) || !isset($user['id']) ){
			?>
			<div id="gz-btn" class="gz-btn btn"><i class="fa fa-plus"></i>关注
			</div>

			<?php
				}else{
			?>
			<div id="gz-btn" class="gz-btn btn followed"><i class="fa fa-check"></i>已关注
			</div>
			<?php
				}
			?>
			<div class="sx-btn btn" id="talkto"><i class="fa fa-envelope"></i>私信</div>
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
				<a href="<?php echo base_url().$people['alias'];?>">
					<li <?php if($type == "quanzi") echo "class='active'"; ?>>
						<div class="icon home_quanzi"></div>
						圈子
					</li>	
				</a>
				<a href="<?php echo base_url().$people['alias'].'/intro';?>">
					<li <?php if($type == "intro") echo "class='active'"; ?>>
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