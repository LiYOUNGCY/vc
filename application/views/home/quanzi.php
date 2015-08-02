<body>
    <?php 
    echo $sidebar;
    ?>
    <input type="hidden" id="userid" value="<?=$user['id']?>">
	<div id="vi_container" class="container">
		<div id="shade"></div>
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
						<img src="<?php echo $user['pic']; ?>">
						<div id="shadow" class="shadow">
							<i class="fa fa-camera"></i>
						</div>
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
						<?php if(isset($media)){ ?>
							<div class="head">
								<img src="<?php echo $user['pic']; ?>">
							</div>
							<div class="name">
								<h3><?=$media['name'];?></h3>
							</div>
							<div class="intro">
								<p>
									<i class="fa fa-quote-left fa-2x pull-left">
										
									</i>
									<?=$media['intro'];?>
								</p>
							</div>
							<div class="infob">
								<i class="fa fa-comments" title="帖子数">
									
								</i>
								<?=$media['post'];?>
								<a href="<?=base_url().'community/'.$media['id']?>">
									<div class="btn">
										进入圈子
										<i class="fa fa-arrow-right" style="margin:0 0 0 5px;">
											
										</i>
									</div>
								</a>
							</div>	
						<?php }?>
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

</body>
<script type="text/javascript" src="<?=base_url().'public/'?>js/vchome.js"></script>
<script type="text/javascript">
	var BASE_URL = $("#BASE_URL").val();
	var GET_COMMU_LIST_URL = BASE_URL +"home/main/get_user_community";
	var uid  = $("#userid").val();
	var PAGE = 1;
	var is_more = 1;
	var jcrop_api;

	window.onload = function() {
		

		loadcommu(0,uid);

		$("#loadmore").click(function(){
			loadcommu(PAGE,uid);
			PAGE++;
		});

		$("#image").css({'display':'none'});

		$('#head').hover(function(){
			$('#shadow').fadeIn(200);
		}, function(){
			$('#shadow').fadeOut(200);
		});

		//点击头像的事件
		$('#head').click(function(){
			$('#headpic').css({'display':'block'});
		});

		$("#save").click(function(){
	        $('form').submit();
	    });

	    $("#cancel").click(function(){
	    	$('#headpic').css({'display':'none'});

	    	jcrop_api.destroy();

	    	if($("#image").css('display') != 'none' ) {
	    		$("#image").css({'display':'none'});
	    	}

	    	if($("#camera_warp").css('display') != 'block' ) {
	    		$("#camera_warp").css({'display':'block'});
	    	}

	    	// $("#camera_warp").css({'display':'block'}); 
	    });
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
	            	var name 	= data[i].name;
	            	var intro   = data[i].intro;
	            	var pic     = data[i].media.pic;
	            	var post 	= data[i].post;
            		element = '<a href="<?=base_url()?>community/'+ id +'"><div class="box"><div class="user"><div class="head"><img src="'+ pic +'"></div><div class="name">'+ name +'</div><div class="intro">'+ intro +'</div></div></div></a>';
	            	$("#qzlist #list").append(element);	
            		
	            	
            	}
            }
		});
	}


	function jcrop_init(tar)
	{
	    $(tar).Jcrop({
	        bgColor: 'black',
	        bgOpacity: 0.4,
	        boundary:2,
	        setSelect: [100, 100, 300 ,300],  //设定4个角的初始位置
	        aspectRatio: 1 / 1,
	        onSelect: showCoords   //当选择完成时执行的函数
	    }, function(){
	    	jcrop_api = this;
	    });    
	}
	function showCoords(c)
	{
	    $("#x").val(c.x);
	    $("#y").val(c.y);
	    $("#w").val(c.w);
	    $("#h").val(c.h);
	}
	//检查裁剪宽度
	function checkCoords()
	{
	    if (parseInt($('#w').val())){
	        $("#img").val(img_src);
	        return true;
	    }
	    alert('Please select a crop region then press submit.');
	    return false;
	}
	function file_upload()
	{
	    var BASE_URL  = $("#BASE_URL").val();
	    var UPLOAD_URL= BASE_URL+'publish/image/upload_headpic';
	    $.ajaxFileUpload({
	        url: UPLOAD_URL,
	        fileElementId: 'upfile',
	        dataType: 'JSON',
	        type:'post',
	        success: function (data) {
	            $("#error_div").html("");
	            if(data.error != null)
	            {
	                $("#error_div").html(data.error);
	            }
	            else
	            {
	                var path = data.filepath
	                img_src  = path;
	                $("#image").attr('src',BASE_URL+path);
	                $('#image').css({'display':'block'});
	                $("#camera_warp").css({'display':'none'});      
	                // $("form").show();                      
	                jcrop_init('#image');   
	            }

	        },
	        error: function (data) {
	            //alert('error');
	        }
	    });    
	}

</script>
</html>