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

		<div id="vi_content" class="content">
			<div id="vi_main" class="main width-100p">
			<div class="quanzi">
				<div id="info" class="info">
					<div class="qzname">
						<h1>艺术大咖</h1>
					</div>
					<div class="qzintro">
						啊实打啊实打啊实打啊实打啊实打奥术
					</div>
					<div class="qzcreater">
						创建者：
						<div class="head">
							<a href="javascript:void();">
							<img src="<?=base_url()?>public/img/mm1.jpg">
							</a>
						</div>
						<a href="javascript:void();" class="link">啊实打实</a>
					</div> 
					<div class="qzopt"></div>	
				</div>
				
				<div class="qzpostlist">
					<div class="box"></div>
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