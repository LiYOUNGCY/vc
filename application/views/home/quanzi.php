<body>
    <?php 
    echo $sidebar;
    ?>
    <input type="hidden" id="userid" value="<?=$user['id']?>">
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
					if(isset($me['id']) && $me['id'] != $user['id']){
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
							<li class="active">
								<div class="icon home_quanzi"></div>
								圈子
							</li>	
						</a>
						<a href="<?php echo base_url().$user['alias'].'/intro';?>">
							<li>
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
				<div id="qzlist" class="qzlist">
				<div class="theqz" id="theqz">
					<div class="qzinfo" id="qzinfo">

					</div>
				</div>
				<div class="title">
					<?php echo $user['name'];?>关注的圈子
				</div>
				<div id="list" class="list">
					
				</div>
				<div id="loadmore" class="loadmore">
					加载更多
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
	var GET_COMMU_LIST_URL = BASE_URL +"home/main/get_user_community";
	var uid  = $("#userid").val();
	var PAGE = 1;
	var is_more = 1;

	window.onload = function() { 
		loadcommu(0,uid);

		$("#loadmore").click(function(){
			loadcommu(PAGE,uid);
			PAGE++;
		})
	}; 

	function loadcommu(pageTemp, id){
		$.ajax({
			url: GET_COMMU_LIST_URL,
			async: false, 
            type: 'POST',
            data: {page : pageTemp, uid:id},
            success:function(data){
            	data = eval("("+data+")");
            	if(data == null || data == ""){
            		$("#loadmore").addClass('disable');
            		$("#loadmore").html("没有更多");
            		$("#loadmore").unbind();
            		return false;
            	}
            	for(var i = 0; i < data.length; i++){
            		var id 			= data[i].id;
            		var element = "";
            		var mediaid = data[i].media.id;
	            	var name 		= data[i].name;
	            	var intro   = data[i].intro;
	            	var pic     = data[i].media.pic;
	            	var post 		= data[i].post;
	            	if(uid == mediaid){
	            		element = '<div class="head"><img src="<?php echo $user['pic']; ?>"></div><div class="name"><h3>'+ name +'</h3></div><div class="intro"><p><i class="fa fa-quote-left fa-2x pull-left"></i>'+ intro +'</p></div><div class="infob"><i class="fa fa-comments" title="帖子数"></i>：'+ post +'<a href="<?=base_url()?>community/'+ id +'"><div class="btn">进入圈子<i class="fa fa-arrow-right" style="margin:0 0 0 5px;"></i></div></a></div>';
	            		$("#theqz #qzinfo").append(element);
            		}else{
	            		element = '<a href="<?=base_url()?>community/'+ id +'"><div class="box"><div class="user"><div class="head"><img src="'+ pic +'"></div><div class="name">'+ name +'</div><div class="intro">'+ intro +'</div></div></div></a>';
		            	$("#qzlist #list").append(element);	
            		}
	            	
            	}
            }
		});
	}

</script>
</html>