
<body>
    <?php 
    echo $sidebar;
    ?>
	<div id="vi_container" class="container">
		<div id="shade"></div>
		<div id="sbtn" class="sbtn">
			<div class="icon sidebtn"></div>
		</div>
		<div id="vi_content" class="content">
		<div id="vc_logo" class="logo" style="padding-top: 159px;">
			<div class="icon logo-a"></div>
		</div>
		<div id="vi_menu" class="vi-menu width-100p">
			<ul>
				<li class="active">
					<a href="<?=base_url()?>feed" class="link">动态</a>
				</li>
				<li>
					<a href="<?=base_url()?>article" class="link">文章</a>
				</li>
				<li>
					<a href="#" class="link">访谈</a>
				</li>
				<li>
					<a href="#" class="link">展览</a>
				</li>
			</ul>
		</div>
		<div id="vi_main" class="width-100p ">
			<div class="main width-100p">
				<div class="ac-right">
					<div class="box ac-user">
						<div class="name">
							<div class="head">
								<a href="#">
									<img src="<?=base_url().'public/'?>img/mm1.jpg" /></a>
							<div class="identity">
									<span class="icon identity"></span>
								</div>
							</div>
							<div class="text">
								<a class="link" href="#">YOUNG啥第第六第六六届CY</a>
							</div>
							<inout type="hidden" value="4" id="userid" />
						</div>
						<div class="public">
							<a href="" class="link">
								<div class="btn">
									<i class="fa fa-file-text"></i>发布文章
								</div>
							</a>
						</div>
					</div>
				</div>
				<div class="ac-left">
					<div class="ac-boxlist clearfix">
					</div>
					<div class="loadmore width-100p">
						<div id="loadmore" class="btn load_btn">
							<font id="text">加载更多</font>
							<i class="fa fa-spinner fa-pulse" style="text-decoration: none;display:none" id="icon"></i>
						</div>
					</div>
				</div>
				
			 </div>
		 </div>
			<div id="vi_footer" class="width-100p">
				<div class="vi_footer">
					<div class="vi_footer_left">
						<div>
							&copy;&nbsp;artvc.cc&nbsp;京ICP备09025489号-4&nbsp;
							<a href="#" class="link">用户协议</a>
							&nbsp;-&nbsp;
							<a href="#" class="link">隐私政策</a>
							&nbsp;-&nbsp;
							<a href="#" class="link">联系我们</a>
							&nbsp;-&nbsp;
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
    loadfeed(0); 
		$(window).bind("scroll",function() {
      	if($(document).scrollTop() + $(window).height() > $(document).height() - 150 && PAGE < 2){
      		$("#loadmore #text").html("加载中");
			$("#loadmore #icon").css({"display":"inline-block"});
      		loadfeed(PAGE);
      		PAGE++;
      		$("#loadmore #text").html("加载更多");
			$("#loadmore #icon").css({"display":"none"});
      	}
  	});
		$("#loadmore").click(function(){
			$("#loadmore #text").html("加载中");
			$("#loadmore #icon").css({"display":"inline-block"});
			loadfeed(PAGE);
			PAGE++;
			$("#loadmore #text").html("加载更多");
			$("#loadmore #icon").css({"display":"none"});
		});
	}; 

	function loadfeed(pageTemp){
	$.ajax({
      url: GET_FEED_LIST_URL,
      async: false, 
      type: 'POST',
      data:{page : pageTemp},
      success: function(data) {
        data = eval("("+data+")"); 
				for(var i = 0; i < data.length; i++)  
				{
					var id 					= data[i].id;
					var feed_type 			= data[i].type;
					var article 			= eval("(" +data[i].content+ ")");
					var article_id			= article.article_id;
					var article_title		= article.article_title;
					var article_content		= article.article_content;
					var user_head_src		= data[i].user.pic;
					var user_name			= data[i].user.name;
					var user_alias			= data[i].user.alias;
					var like				= data[i].like;
					var like_num			= like.length;
					var time 				= data[i].publish_time;
					var element 			=	"";
					if(feed_type == 1){
						var author			= data[i].author.name;
						var author_alias	= data[i].author.alias;	
						var action			= '<a class="link" href="#">'+ user_name +'</a>赞了<a class="link" href="#">'+ author +'</a>的一篇文章';
					}else{
						var action			= '<a class="link" href="#">'+ user_name +'</a>发布了一篇文章';
					}

					element = '<div class="box"><div class="boxtop"><div class="name"><div class="head"><a href="#"><img src="'+ user_head_src +'" /></a><div class="identity"><span class="icon identity"></span></div></div><div class="text">'+ action +'</div></div><div class="time"><time class="timeago" title="'+ time +'" datetime="'+ time +'+08:00"></time></div></div><div class="article"><div class="ar_text"><div class="title"><a class="link" href="'+ BASE_URL +'article/'+article_id+'">'+ article_title +'</a></div><div class="con"><p>'+ article_content +'</p></div></div><div class="ar_pic"><a href="'+ BASE_URL +'article/'+article_id+'"><img  id="'+ id +'"></a></div></div><div class="support"><div class="like float-l"><div class="btn"><i class="fa fa-heart"></i> '+ like_num +'</div></div><div class="list">';
					for(var y = 0; y < like.length; y++){
						element += '<div class="head"><img title="'+ like[y].name +'" src="'+ like[y].pic +'"></div>';
					}
					element += '</div></div></div>';
					$(".ac-boxlist").append(element);
					$(".timeago").timeago();
				}
      }
	});

	$.ajax({
        url: GET_FEED_LIST_URL,
        type: 'POST',
        data:{page : pageTemp},
        success: function(data) {
          data = eval("("+data+")"); 
				for(var i = 0; i < data.length; i++)  
				{  
					var article 	= eval("(" +data[i].content+ ")");
					var id 			= data[i].id;
					var image 		= article.article_image;
					$(".ar_pic #"+id).attr("src",image);
				}
    	}
    });
	}



</script>
</html>