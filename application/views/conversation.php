<body>
    <div class="container-960">
        <div class="container-head">
            <h1>消息中心</h1>
            <div id="vi_menu" class="vi-menu width-100p">
            <ul>
                <li>
                    <a href="#" class="link">发现</a>
                </li>
                <li class="active">
                    <a href="#" class="link">动态</a>
                </li>
                <li>
                    <a href="#" class="link">作品</a>
                </li>
                <li>
                    <a href="#" class="link">文章</a>
                </li>
            </ul>
        </div>
        </div>
        <div class="conversation">
            <div class="clearfix">
                <div id="submit" class="send btn">发送</div>
                <div id="emotion" class="emotion"></div>
                <div class="msg"><textarea id="msg"  placeholder="想说写什么..."></textarea></div>
            </div>

            <div class="message clearfix">

                <div class="message-box message-left">
                    <div class="message-content">
                        <div class="triangle-left"></div>
                        <div class="avatar avatar-left">
                            <img src="<?=base_url().'public/'?>img/mm1.jpg">
                            <div class="username">鸡巴白</div>
                        </div>
                        <p>qwer</p>
                    </div>
                </div>

                <div class="message-box message-left">
                    <div class="message-content">
                        <div class="triangle-left"></div>
                        <div class="avatar avatar-left">
                            <img src="<?=base_url().'public/'?>img/mm1.jpg">
                            <div class="username">鸡巴白</div>
                        </div>
                        <p>qwer鸡巴白鸡巴白鸡巴白鸡巴白鸡巴白鸡巴白鸡巴白鸡巴白鸡巴白鸡巴白鸡巴白鸡巴白鸡qwer鸡巴白鸡巴白鸡巴白鸡巴白鸡巴白鸡巴白鸡巴白鸡巴白鸡巴白鸡巴白鸡巴白鸡巴白鸡巴白鸡巴白鸡巴白qwer鸡巴白鸡巴白鸡巴白鸡巴白鸡巴白鸡巴白鸡巴白鸡巴白鸡巴白鸡巴白鸡巴白鸡巴白鸡巴白鸡巴白鸡巴白巴白鸡巴白鸡巴白</p>
                    </div>
                </div>

                <div class="time-box">2015-7-24</div>

                <div class="message-box message-right">
                    <div class="message-content">
                        <div class="triangle-right"></div>
                        <div class="avatar avatar-right">
                            <img src="<?=base_url().'public/'?>img/mm1.jpg">
                            <div class="username">鸡巴白</div>
                        </div>
                        <p>rewq</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</body>
	<script>
        function replace_em(URL, str){ 
            str = str.replace(/\</g,'<；'); 
            str = str.replace(/\>/g,'>；'); 
            str = str.replace(/\n/g,'<；br/>；'); 
            str = str.replace(/\[em_([0-9]*)\]/g,'<img src=' + URL + '"/$1.gif" border="0" />'); 
            return str; 
        }
		$(function(){
            var BASE_URL = $("#BASE_URL").val();
			 $('#msg').flexText();
             $('#emotion').qqFace({ 
                assign: 'msg',   //给输入框赋值 
                path: BASE_URL + "public/img/face/"    //表情图片存放的路径 
            });

            $("#submit").click(function(){ 
                var str = replace_em(BASE_URL + "public/img/face/", $("#msg").val());
                alert(str);
            });
		});
	</script>
</html>