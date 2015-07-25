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
  <input id="BASE_URL" type="hidden" value="<?=base_url()?>">
 </head> 
 <body style="height:100%;overflow: hidden;"> 
  <div id="vc_sidebar" class="sidebar"> 
   <div class="name"> 
    <div class="head"> 
     <a class="link" href="#"> <img src="<?=base_url().'public/'?>img/mm1.jpg" /> </a> 
    </div> 
    <div class="text"> 
     <a class="link" href="#"> YOUNGCY </a> 
     <div class="identity"> 
      <span class="icon identity"></span> 
     </div> 
    </div> 
   </div> 
   <div class="search"> 
    <input type="text" /> 
    <div> 
     <a class="link" href="#"><i class="fa fa-search"></i></a> 
    </div> 
   </div> 
   <div class="menu"> 
    <ul> 
     <li class="menu-list"> 
      <div class="menu-list-item"> 
       <a class="link" href="dfdfdf"> 
        <div class="icon"> 
         <div class="home"></div> 
        </div> <span class="menu-list-item-text">个人首页</span> </a> 
      </div> </li> 
     <a class="link" href="asasdas"> <li class="menu-list active"> 
       <div class="menu-list-item"> 
        <div class="icon"> 
         <div class="guanzhu"></div> 
        </div> 
        <span class="menu-list-item-text">我的关注</span> 
       </div> </li> </a> 
     <li class="menu-list"> 
      <div class="menu-list-item"> 
       <a class="link" href="#"> 
        <div class="icon"> 
         <div class="tongji"></div> 
        </div> <span class="menu-list-item-text">统计</span> </a> 
      </div> </li> 
     <li class="menu-list"> 
      <div class="menu-list-item"> 
       <a class="link" href="#"> 
        <div class="icon"> 
         <div class="sixin"></div> 
        </div> <span class="menu-list-item-text">私信</span> </a> 
      </div> </li> 
     <li class="menu-list"> 
      <div class="menu-list-item"> 
       <a class="link" href="#"> 
        <div class="icon"> 
         <div class="setting"></div> 
        </div> <span class="menu-list-item-text">设置</span> </a> 
      </div> </li> 
     <li class="menu-list"> 
      <div class="menu-list-item"> 
       <a href="#" class="link"> 
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
      <a class="link" href="javascript:void(0);">
       <div class="logo-w"></div></a>  
     </div>
     <span class="text"> <a href="" class="link"><b>艺术维C</b></a><br /> affecting the life in a mysterious way </span>
    </div> 
    <div class="logtext"> 
     <div class="float-l">
      <font class="big">欢迎登陆</font>
      <font style="font-size:70%;text-decoration: underline;font-weight:bold;"><a class="link" href="<?=base_url()?>signup">注册账号</a></font> 
     </div> 
    </div> 
    <div id="login" class="logform width-100p "> 
     <div class="formcon">

       <div class="form"> 
        <input type="text" id="username" placeholder="手机号/邮箱" /> 
        <hr style="color:#B3B3B3;" /> 
        <input type="password" id="password" placeholder="密码" /> 
       </div> 
       <div class="width-100p"> 
        <a class="link" href="javascript:login();"> 
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
         <a class="link" href="#">忘记密码</a> 
        </div> 
       </div> 

     </div> 
    </div> 
    <div id="vi_footer" class="width-100p logfooter"> 
     <div class="vi_footer" style="margin-top:130px"> 
      <div class="vi_footer_left"> 
       <div>
         &copy;&nbsp;artvc.cc&nbsp;京ICP备09025489号-4&nbsp; 
        <a class="link" href="#">用户协议</a>&nbsp;-&nbsp;
        <a class="link" href="#">隐私政策</a>&nbsp;-&nbsp;
        <a class="link" href="#">联系我们</a>&nbsp;-&nbsp;
        <a class="link" href="#">意见反馈</a> 
       </div> 
      </div> 
     </div> 
    </div> 
   </div> 
  </div>  
  <script type="text/javascript" src="<?=base_url().'public/'?>js/vchome.js"></script> 
  <script type="text/javascript">
$(function(){
  

  $("#login #password").bind('keypress',function(event){
    
    if(event.keyCode == "13")
    {
      login(BASE_URL);
    }
  });

});
	
	
	function login(URL){ 
		var username = $("#username").val();
		var password = $("#password").val();
    var URL = $("#BASE_URL").val();

    var PHONE_LOGIN_URL = URL + "account/main/login_by_phone";
    var EMAIL_LOGIN_URL = URL + "account/main/login_by_email";

		var ce = !!username.match("^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$");
		var cp = !!username.match("^(0|86|17951)?(13[0-9]|15[012356789]|17[678]|18[0-9]|14[57])[0-9]{8}$");
	  	var is_remember = $("#rememberme").attr("checked");
		if(is_remember == "checked") is_remember = 1; else is_remember = 0;

	  
	  
		if( ce == true ){
		  	$.post(
				EMAIL_LOGIN_URL,{
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
				PHONE_LOGIN_URL,{
					phone	 : username,
					pwd		 :	password,
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