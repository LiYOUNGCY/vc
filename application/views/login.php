<!DOCTYPE html>
<html style="height:100%;">
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
 </head> 
 <body style="height:100%;overflow: hidden;"> 
  <div id="vc_sidebar" class="sidebar"> 
   <div class="name"> 
    <div class="head"> 
     <a href="#"> <img src="<?=base_url().'public/'?>img/mm1.jpg" /> </a> 
    </div> 
    <div class="text"> 
     <a href="#"> YOUNGCY </a> 
     <div class="identity"> 
      <span class="icon identity"></span> 
     </div> 
    </div> 
   </div> 
   <div class="search"> 
    <input type="text" /> 
    <div> 
     <a href="#"><i class="fa fa-search"></i></a> 
    </div> 
   </div> 
   <div class="menu"> 
    <ul> 
     <li class="menu-list"> 
      <div class="menu-list-item"> 
       <a href="dfdfdf"> 
        <div class="icon"> 
         <div class="home"></div> 
        </div> <span class="menu-list-item-text">个人首页</span> </a> 
      </div> </li> 
     <a href="asasdas"> <li class="menu-list active"> 
       <div class="menu-list-item"> 
        <div class="icon"> 
         <div class="guanzhu"></div> 
        </div> 
        <span class="menu-list-item-text">我的关注</span> 
       </div> </li> </a> 
     <li class="menu-list"> 
      <div class="menu-list-item"> 
       <a href="#"> 
        <div class="icon"> 
         <div class="tongji"></div> 
        </div> <span class="menu-list-item-text">统计</span> </a> 
      </div> </li> 
     <li class="menu-list"> 
      <div class="menu-list-item"> 
       <a href="#"> 
        <div class="icon"> 
         <div class="sixin"></div> 
        </div> <span class="menu-list-item-text">私信</span> </a> 
      </div> </li> 
     <li class="menu-list"> 
      <div class="menu-list-item"> 
       <a href="#"> 
        <div class="icon"> 
         <div class="setting"></div> 
        </div> <span class="menu-list-item-text">设置</span> </a> 
      </div> </li> 
     <li class="menu-list"> 
      <div class="menu-list-item"> 
       <a href="#"> 
        <div class="icon"> 
         <div class="logout"></div> 
        </div> <span class="menu-list-item-text">退出</span> </a> 
      </div> </li> 
    </ul> 
   </div> 
  </div> 
  <div id="vi_container" class="container"> 
   <div id="loginbg" class="loginbg"> 
   </div> 
   <div id="shade"></div> 
   <div id="sbtn" class="sbtn"> 
    <div class="icon"> 
     <div class="sidebtn"></div> 
    </div> 
   </div> 
   <div id="vl_content" class="content"> 
    <div class="loginlogo"> 
     <div class="icon"> 
      <a href="javascript:void(0);">
       <div class="logo-w"></div></a>  
     </div>
     <span class="text"> <b>艺术维C</b><br /> affecting the life in a mysterious way </span>
    </div> 
    <div class="logtext"> 
     <div class="float-l">
       欢迎登陆
      <font style="margin:0 10px;font-size:200%;letter-spacing: 0px;">artVC</font>
      <i style="color:#FCEE21;font-weight: bold;padding:0 10px;font-size:70%;">/</i>
      <font style="font-size:70%;text-decoration: underline;"><a href="#">注册账号</a></font> 
     </div> 
    </div> 
    <div id="login" class="logform width-100p"> 
     <div class="formcon"> 
      <form name="login_form" novalidate="novalidate"> 
       <div class="form"> 
        <input type="text" id="username" placeholder="手机号/邮箱" /> 
        <hr style="color:#B3B3B3;" /> 
        <input type="password" id="password" placeholder="密码" /> 
       </div> 
       <div class="width-100p"> 
        <a href="javascript:login();"> 
         <div class="loginbtn btn">
          登陆
         </div> </a> 
       </div> 
       <div class="width-100p loginoption" style="display:inline-block"> 
        <div class="remember"> 
         <input type="checkbox" value="1" id="rememberme" name="" style="display:none;" /> 
         <label for="rememberme"></label> 
        </div> 
        <div class="text float-l"> 
         <label for="rememberme">下次自动登录 </label> 
        </div> 
        <div class="text float-r"> 
         <a href="#">忘记密码</a> 
        </div> 
       </div> 
      </form>
     </div> 
    </div> 
    <div id="vi_footer" class="width-100p"> 
     <div class="vi_footer" style="margin-top:70px"> 
      <div class="vi_footer_left"> 
       <div>
         &copy;&nbsp;artvc.cc&nbsp;京ICP备09025489号-4&nbsp; 
        <a href="#">用户协议</a>&nbsp;-&nbsp;
        <a href="#">隐私政策</a>&nbsp;-&nbsp;
        <a href="#">联系我们</a>&nbsp;-&nbsp;
        <a href="#">意见反馈</a> 
        qwertyuiopqwertyuiopqwertyuiop
        意见反馈意见反馈
        yi
        亿
       </div> 
      </div> 
     </div> 
    </div> 
   </div> 
  </div>  
  <script type="text/javascript" src="<?=base_url().'public/'?>js/vchome.js"></script> 
  <script type="text/javascript">

	$("#login #password").bind('keypress',function(event){
		if(event.keyCode == "13")
		{
			login();
		}
	})
	
	function login(){ 
		var username = $("#username").val();
		var password = $("#password").val();
		var LOGIN_URL = "login";
		var ce = !!username.match("^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$");
		var cp = !!username.match("^(0|86|17951)?(13[0-9]|15[012356789]|17[678]|18[0-9]|14[57])[0-9]{8}$");
	  	var is_remember = $("#rememberme").attr("checked");
		if(is_remember == "checked") is_remember = 1; else is_remember = 0;

	  
	  
		if( ce == true ){
		  	$.post(
				LOGIN_URL,{
					email	: username,
					pwd			:	password,
					rememberme : is_remember
				},function(data){
					alert(data);
				}
			)
		}
		else if( cp == true ){
		  	$.post(
				login_URL,{
					phone	: username,
					pwd			:	password,
					rememberme : is_remember
				},function(data){
					alert(data);
				}
			)
		}

	}
  </script>
 </body>
</html>