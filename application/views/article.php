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
	<input type="hidden" value="<?=base_url()?>" id="BASE_URL"> 
</head>
<body>
	<div id="vc_sidebar" class="sidebar">
		<div class="name">
			<div class="head">
				<a class="link" href="#">
					<img src="<?=base_url().'public/'?>img/mm1.jpg" /></a>
			</div>
			<div class="text">
				<a class="link" href="#">YOUNGCY</a>
				<div class="icon">
					<span class="identity"></span>
				</div>
			</div>
		</div>
		<div class="menu">
			<ul>
				<a class="link" href="<?=base_url()?>article">
				<li class="menu-list active">
					<div class="menu-list-item">
						<div class="icon"><div class="home"></div></div>
						<span class="menu-list-item-text">首页</span>
					</div>
				</li>
				<a class="link" href="<?=base_url()?>login">		
				<li class="menu-list">
					<div class="menu-list-item">
						<div class="icon"><div class="sixin"></div></div>
						<span class="menu-list-item-text">登陆</span>
					</div>
				</li>
				</a>
				<a class="link" href="<?=base_url()?>signup">		
				<li class="menu-list">
					<div class="menu-list-item">
						<div class="icon"><div class="sixin"></div></div>
						<span class="menu-list-item-text">注册</span>
					</div>
				</li>
				</a>
				</a>
				<a class="link" href="<?=base_url()?>notification/conversation">		
				<li class="menu-list">
					<div class="menu-list-item">
						<div class="icon"><div class="sixin"></div></div>
						<span class="menu-list-item-text">消息</span>
					</div>
				</li>
				</a>
				<a class="link" href="<?=base_url()?>setting">
				<li class="menu-list">
					<div class="menu-list-item">
						<div class="icon"><div class="setting"></div></div>
						<span class="menu-list-item-text">设置</span>
					</div>
				</li>
				</a>
				<a class="link" id="showlang" href="javascript:void(0);">
				<li class="menu-list">
					<div class="menu-list-item">
						<div class="icon">
							<div class="logout"></div>
						</div>
						<span class="menu-list-item-text">语言</span>
					</div>
				</li>
				</a>
				<div class="lop" id="lop">
					<div id="lop-zh" style="border-right: 1px solid #4C4640;" class="btn">简体中文</div>
					<div id="lop-en" class="btn">English</div>
				</div>
				<a class="link" href="#">
				<li class="menu-list">
					<div class="menu-list-item">
						<div class="icon">
							<div class="logout"></div>
						</div>
						<span class="menu-list-item-text">退出</span>
					</div>
				</li>
				</a>
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
		<div id="vi_content" class="content">
			<!--                <div id="vi_user" class="vi-user float-r">
			<a href="/" class="link">YOUNGCY</a>
		</div>
		-->
		<div id="vi_sign" class="vi-sign ">
			<div class="float-r">
				<a href="<?=base_url()?>account/main" class="link sign">登陆</a>
				<a href="<?=base_url()?>account/main/signup" class="link">注册</a>
			</div>
		</div>
		<div id="vc_logo" class="logo">
			<div class="icon">
				<div class="logo-a"></div>
			</div>
		</div>
		<div id="vi_menu" class="vi-menu width-100p">
			<ul>
				<li>
					<a href="<?=base_url()?>feed" class="link">动态</a>
				</li>
				<li class="active">
					<a href="<?=base_url()?>article" class="link">文章</a>
				</li>
				<li>
					<a href="#" class="link"></a>
				</li>

			</ul>
		</div>
		<div id="vi_main" class="width-100p ">
			<div class="main width-100p">
				<ul id="article_list">

					</ul>
					<div class="loadmore width-100p">
						<div id="loadmore" class="btn load_btn">
							<font id="text">加载更多</font>
							<i class="fa fa-spinner fa-pulse" style="text-decoration: none;display:none" id="icon"></i>
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
	var GET_ARTICLE_URL = document.getElementById("BASE_URL").value+"article/main/get_article_list";
	var ARTICLE_DETAIL_URL = document.getElementById("BASE_URL").value+"article/detail/index/";
	var PAGE = 1;
	window.onload = function() { 
        loadarticel(0);
		$(window).bind("scroll",function() {
        	if($(document).scrollTop() + $(window).height() > $(document).height() - 150 && PAGE < 2){
        		$("#loadmore #text").html("加载中");
				$("#loadmore #icon").css({"display":"inline-block"});
        		loadarticel(PAGE);
        		PAGE++;
        		$("#loadmore #text").html("加载更多");
				$("#loadmore #icon").css({"display":"none"});
        	}
    	});



		$("#loadmore").click(function(){
			$("#loadmore #text").html("加载中");
			$("#loadmore #icon").css({"display":"inline-block"});
			loadarticel(PAGE);
			PAGE++;
			$("#loadmore #text").html("加载更多");
			$("#loadmore #icon").css({"display":"none"});
		});
	}; 

	function loadarticel(pageTemp){
		$.ajax({
            url: GET_ARTICLE_URL,
            async: false, 
            type: 'POST',
            data:{page : pageTemp},
            success: function(data) {
                data = eval("("+data+")"); 
				for(var i = 0; i < data.length; i++)  
				{  
					var id			= data[i].content.article_id;
					var title 		= data[i].content.article_title;
					var content		= data[i].content.article_content;
					var image 		= data[i].content.article_image;
					var like 		= data[i].like;
					var status 		= data[i].status;
					var author_role	= data[i].author.role;
					var author_name	= data[i].author.name;
					var author_pic	= data[i].author.pic;
					var author_alias= data[i].author.alias;

					var element 	= "<li><div class='article'><div class='article-box'><div id='arimg' class='arimg'><img id='"+id+"'></div><div class='armain width-100p'><div class='clearfix hide-y' style='margin: 10px 10px;'><span class='artitle'><a href='"+ARTICLE_DETAIL_URL+id+"' class='link'>"+title+"</a></span><div class='arlike float-r'><div class='icon'>"+like;
					if(status == "null"){
						alert("1");
						element += "<div class='unlike'></div>"
					}else{
						element += "<div class='like'></div>"
					}
					element += "</div></div></div><div class='arcon width-100p clearfix'><div class='name'><a href='javascript:void(0);'><div class='head'><img src='"+author_pic+"'></div></a><div class='username'><a href='javascript:void(0);' class='link'>"+author_name+"</a></div></div><div class='artext'><p>"+content+"</p></div></div><div class='arbtn margintop-10'><a href='"+ARTICLE_DETAIL_URL+id+"' class='link btn'>阅读文章</a></div></div></div></li>";
					$("#article_list").append(element);
				}
            }
        });

		$.ajax({
            url: GET_ARTICLE_URL,
            type: 'POST',
            data:{page : pageTemp},
            success: function(data) {
                data = eval("("+data+")"); 
				for(var i = 0; i < data.length; i++)  
				{  
					var id			= data[i].content.article_id;
					var image 		= data[i].content.article_image;
					$("#arimg #"+id).attr("src",image);
				}
            }
        });
	}
// {
// "content": {
// "article_id": "20",
// "article_title": "321321",
// "article_subtitle": "32132132",
// "article_content": "受打击阿斯顿空间啊是宽带连接阿凯圣诞节阿里靠的就是卡萨达加乱圣诞节卡了圣诞节啦空间的辣椒水的乱圣诞节了卡萨达加拉开圣诞加乱圣诞节卡了圣诞节啦空间的辣椒水的乱圣诞节了卡萨达加拉开圣诞节乱圣诞节拉伸到敬爱...",
// "article_image": "http://hanzh.oss-cn-shenzhen.aliyuncs.com/public/upload/20150717/14371211881391.png"
// },
// "like": "0",
// "author": {
// "role": "1",
// "name": "aa",
// "pic": null,
// "alias": null
// }
// }


</script>
</html>