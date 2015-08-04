<body>
    <?php 
    echo $sidebar;
    ?>
    <?php 
     	$uid = isset($user['id']) ? $user['id'] : NULL;
    ?>
    <input type="hidden" id="userid" value="<?=$uid?>">
    <input type="hidden" id="CID" value="<?=$community['community']['id']?>">    
	<div id="vi_container" class="container">
		<div id="shade"></div>
		<div id="vi_content" class="content">
			<div id="vi_main" class="main width-100p">
			<div class="quanzi">
				<div id="info" class="info">
					<div class="qzname">
						<h1><?=$community['community']['name']?></h1>
					</div>
					<div class="qzintro">
						<?=$community['community']['intro']?>
					</div>
					<div class="qzcreater">
						创建者：
						<div class="head">
							<a href="<?=base_url().$community['media']['alias']?>">
							<img src="<?=$community['media']['pic']?>">
							</a>
						</div>
						<a href="javascript:void();" class="link"><?=$community['media']['name']?></a>
						
					</div>  
					<?php if(isset($user['id']) && $user['id'] == $community['media']['id']){ ?>
					<div class="qzopt">
						<div class="btn publish">发帖子</div>
						<div class="btn setting">设置</div>
					</div>
					<?php }?>	
				</div>
				
				<div class="qzpostlist">

				</div>
			</div>

			</div>
			<?=$footer?>
		</div>

	</div>
	<script type="text/javascript" src="<?=base_url().'public/'?>js/vc.js"></script>
</body>
<script type="text/javascript">
	var BASE_URL = $("#BASE_URL").val();
	var GET_POST_LIST_URL = BASE_URL +"community/main/get_community";
	var uid  = $("#userid").val();
	var cid  = $("#CID").val();
	var PAGE = 0;
	var is_more = 1;

	window.onload = function() {
		loadcommu(PAGE,cid);
		$(".timeago").timeago();
	};

	function loadcommu(pageTemp, id){
		$.ajax({
			url: GET_POST_LIST_URL,
			async: false, 
            type: 'POST',
            data: {page : pageTemp, cid:id},
            success:function(data){
            	data = eval("("+data+")");
            	if(data.error != null)
            	{
            		ERROR_OUTPUT(data);
            		return false;
            	}
            	if(data == null || data == ""){
            		$("#loadmore").addClass('disable');
            		$("#loadmore").html("没有更多");
            		$("#loadmore").unbind();
            		return false;
            	}
            	var str = "";
            	for(var i = 0; i < data.length; i++){

            		var name		 = data[i].user.name;
            		var alias 		 = data[i].user.alias;
            		var pic 		 = data[i].user.pic;
            		var id 			 = data[i].id;
            		var title 		 = data[i].title;
            		var content 	 = data[i].content;
            		var answer 		 = data[i].answer;
            		var publish_time = data[i].publish_time;
            		var last_active  = data[i].last_active;    
            		var has_img      = data[i].has_img;
            		str += '<div class="box"><div class="postuser"><div class="head"><a href="<?php echo base_url()?>'+alias+'"><img src="'+pic+'"></a></div><div class="name"><a class="link" href="<?php echo base_url()?>'+alias+'">'+name+'</a></div></div><div class="postinfo"><div class="posttitle"><div class="title"><a class="link" href="<?=base_url()?>post/'+id+'">'+title+'</a></div>';
            		if(has_img == 1)
            		{
            			str += '<i class="fa fa-image"></i>';
            		}
            		str += '</div><div class="postcon"><p>'+content+'<a href="<?=base_url()?>post/'+id+'" class="link">[阅读全文]</a></p></div><div class="other"><div class="time float-l"><time class="timeago" title="'+publish_time+'" datetime="'+publish_time+'+08:00"></time></div><div class="comment float-r"><i class="fa fa-comment"></i>'+answer+'</div></div></div><div class="delete">';
            		if(data.uid == uid)
            		{
            			str += '<i class="fa fa-close"></i>';
            		}
            		str += '</div></div>';
            	}
            	$(".qzpostlist").append(str);
            }
		});
	}

</script>
</html>