<body>
	<?=$sidebar?>
	<div id="vi_container" class="container">
		<input type="hidden" name="article_type" value="<?php echo $article_type;?>" />
		<input type="hidden" name="article_tag"  value="<?php echo $article_tag;?>"/>
		<div id="shade"></div>
		<div id="vi_content" class="content">
		<?php if( $user['role'] == 0) { ?>
			<div id="vi_sign" class="vi-sign ">
				<div class="float-r">
					<a href="<?=base_url()?>login" class="link sign">登陆</a>
					<a href="<?=base_url()?>signup" class="link">注册</a>
				</div>
			</div>
		<?php }  ?>
		<div id="vc_logo" class="logo">
			<div class="icon logo-a"></div>
		</div>
		<div id="vi_menu" class="vi-menu width-100p">
			<ul>
				<?php 
					if(isset($user['id'])){
				?>
				<li>
					<a href="<?=base_url()?>feed" class="link">动态</a>
				</li>
				<?php 
					}
				?>
				
				<li class="active">
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
	<script type="text/javascript" src="<?=base_url().'public/'?>js/vc.js"></script>
</body>
<script type="text/javascript">
	var BASE_URL = document.getElementById("BASE_URL").value;
	var GET_ARTICLE_URL = document.getElementById("BASE_URL").value+"article/main/get_article_list";
	var ARTICLE_DETAIL_URL = document.getElementById("BASE_URL").value+"article/";
    var ARGEE_URL = BASE_URL + 'article/detail/vote_article';
	var PAGE = 1;

	window.onload = function() { 
        loadarticel(0);
        
		$(window).bind("scroll",function() {
        	if($(document).scrollTop() + $(window).height() > $(document).height() - 150 && PAGE < 2){
                $(window).unbind();
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

        
        $('.likebtn2').click(function(){
            var tar = $(this);
            var aid = $(this).attr('data_row');

            $.ajax({
                type: 'POST',
                url: ARGEE_URL,
                async: false,
                data: {
                  aid: aid
                },
                success:function(data){
                  var status = eval('(' + data + ')');
                  if(status.success == 0) {
                    if(tar.hasClass('focus')) {
                        tar.prev().html(parseInt(tar.prev().html())+1);
                    }
                    else {
                        tar.prev().html(parseInt(tar.prev().html())-1);
                    }
                  }
                  else if(status.error != null)
                  {
                     ERROR_OUTPUT(status);
                     return false;
                  }
                }
              });
        });
	}; 

	function loadarticel(pageTemp){
		var type = $("input[name=article_type]").val();
		var tag  = $("input[name=article_tag]").val();
		$.ajax({
            url: GET_ARTICLE_URL,
            async: false, 
            type: 'POST',
            data:{page : pageTemp, type:type, tag:tag},
            success: function(data) {
                //alert(data);
                data = eval("("+data+")");
                //没有数据
                if(data == null || data == "")
                {
                	$("#loadmore").unbind();
 					return false;
                }
                //错误
                if(data.error != null)
                {
                	return false;
                } 
				for(var i = 0; i < data.length; i++)  
				{  
					var id			= data[i].content.article_id;
					var sort_title	= data[i].content.sort_title;
					var title 		= data[i].content.article_title;
					var content		= data[i].content.article_content;
					var image 		= data[i].content.article_image;
					var like 		= data[i].like;
					var status 		= data[i].status;
					var author_role	= data[i].author.role;
					var author_name	= data[i].author.name;
					var author_pic	= data[i].author.pic;
					var author_alias= data[i].author.alias;
					var element 	= "<li><div class='article'><div class='article-box'><div id='arimg' class='arimg'><a title='"+title+"' href='"+ARTICLE_DETAIL_URL+id+"'><img id='"+id+"'  data-url='"+image+"' class='img-lazyload_"+pageTemp+"' ></a></div><div class='armain width-100p'><div class='clearfix hide-y' style='margin: 10px 10px;'><span class='artitle'><a title='"+title+"' href='"+ARTICLE_DETAIL_URL+id+"' class='link'>"+sort_title+"</a></span><div class='arlike float-r'><span>"+like + "</span>";
					if(status == '1'){
                        element += "<div data_row='"+ id +"' class='likebtn2 focus' onclick='support(this)'></div>";
					}else{
						element += "<div data_row='"+ id +"' class='likebtn2' onclick='support(this)'></div>";
					}
					element += "</div></div><div class='arcon width-100p clearfix'><div class='name'><a href='javascript:void(0);'><div class='head'><a href='"+BASE_URL + author_alias+"' class='link'><img src='"+author_pic+"'></a></div></a><div class='username'><a href='"+BASE_URL + author_alias+"' class='link'>"+author_name+"</a></div></div><div class='artext'><p>"+content+"</p></div></div><div class='arbtn margintop-10'><a href='"+ARTICLE_DETAIL_URL+id+"' class='link btn'>阅读文章</a></div></div></div></li>";
					$("#article_list").append(element);
				}
				//图片异步加载
                $(".img-lazyload_"+pageTemp).scrollLoading();
			
            }
        });
	}

	function support(obj){
		if($(obj).hasClass('focus')){
			$(obj).attr('class','likebtn2 blur');
		}else{
			$(obj).attr('class','likebtn2 focus');
		}
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