<!DOCTYPE html>
<html style="height:100%;">
 <head> 
  <meta charset="utf-8" /> 
  <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" /> 
  <meta name="apple-mobile-web-app-capable" content="yes" /> 
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" /> 
  <meta name="format-detection" content="telephone=yes" /> 
  <meta name="msapplication-tap-highlight" content="no" /> 
  <script type="text/javascript" src="<?=base_url().'public/'?>js/jquery.js"></script> 
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
    <input id="" name="" type="text" /> 
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
       <a class="link" href="#"> 
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
      <a class="link" href="javascript:void(0);"><div class="icon logo-w"></div></a> 
     <span class="text"> <a href="" class="link"><b>艺术维C</b></a><br /> affecting the life in a mysterious way </span>
    </div>
    <div class="logtext"> 
     <div class="float-l">
        <font class="big">欢迎注册</font>
        <font style="font-size:70%;text-decoration: underline;font-weight:bold;"><a class="link" href="<?=base_url()?>login">登陆</a></font>
      </font> 
     </div>  
    </div> 
    <div class="logform width-100p"> 
     <div class="formcon">
      <div class="float-r " style="margin-bottom:5px;font-weight:bold;display:none;" id="tophone" ><a class="link" href="javascript:void(0);" id="change">使用手机注册</a></div> 
      <div class="float-r " style="margin-bottom:5px;font-weight:bold;display:block;" id="toemail"><a class="link" href="javascript:void(0);" id="change">使用邮箱注册</a></div> 
      <div class="form" id="phone_sign"> 
        <input type="text" id="phone" placeholder="手机号" /> 
        <hr style="color:#B3B3B3;" /> 
        <input type="password" id="password" placeholder="密码" /> 
       </div>
       <div class="form" style="display:none;" id="email_sign"> 
        <input type="text" id="email" placeholder="邮箱地址" /> 
        <hr style="color:#B3B3B3;" /> 
        <input type="password" id="password" placeholder="密码" /> 
       </div>

       <div class="width-100p"> 
        <a class="link" href="javascript:signup();"> 
         <div class="loginbtn btn">
          注册
         </div> </a> 
       </div> 
        
        <input id="signway" type="hidden" value="phone">
     </div> 
    </div> 
    <div id="vi_footer" class="width-100p logfooter"> 
     <div class="vi_footer" style="margin-top:130px"> 
      <div class="vi_footer_left"> 
       <div>
         &copy;&nbsp;artvc.cc&nbsp;京ICP备09025489号-4&nbsp; 
        <a class="link" href="javascript:void(0);">用户协议</a>&nbsp;-&nbsp;
        <a class="link" href="javascript:void(0);">隐私政策</a>&nbsp;-&nbsp;
        <a class="link" href="javascript:void(0);">联系我们</a>&nbsp;-&nbsp;
        <a class="link" href="javascript:void(0);">意见反馈</a> 
       </div> 
      </div> 
     </div> 
    </div> 
   </div> 
  </div>  
  <script type="text/javascript" src="<?=base_url().'public/'?>js/vchome.js"></script> 
  <script type="text/javascript">

	$(function() {
		$("#toemail").click(function() {
			$(this).css({"display":"none"});
			$("#phone_sign").css({"display":"none"});
		  	$("#phone_sign input").each(function(i){
				$(this).val("");
			});
		  	$("#signway").val("email");
			$("#email_sign").css({"display":"block"});
			$("#tophone").css({"display":"block"});
	  	
		})

		$("#tophone").click(function() {
			$(this).css({"display":"none"});
			$("#phone_sign").css({"display":"block"});
		  	$("#email_sign input").each(function(i){
				$(this).val("");
			});
		  	$("#signway").val("phone");
			$("#email_sign").css({"display":"none"});
			$("#toemail").css({"display":"block"});
		})
	})
		
		
		function signup(){ 
        var BASE_URL = $("#BASE_URL").val();
		  	var EMAIL_SIGNUP_URL = BASE_URL + "account/main/register_by_email";
        var PHONE_SIGNUP_URL = BASE_URL + "account/main/register_by_phone";

		  	var signup_way = $("#signway").val();
        
		  	if( signup_way == "phone" ){

				var phone = $("#phone_sign #phone").val();
				var pwd = $("#phone_sign #password").val();
			  	var cp = !!phone.match(/^(0|86|17951)?(13[0-9]|15[012356789]|17[678]|18[0-9]|14[57])[0-9]{8}$/);
			  	if(cp == true){

					$.post(
						PHONE_SIGNUP_URL,{
							phone	: phone,
							pwd		: pwd,
							name	: phone
						},function(data){
							alert(eval("("+data+")").error);
						}
					)
				}else{
					alert("请填入正确的手机号码");
				}
			}
		  	else{
				var email = $("#email_sign #email").val();
			  var pwd = $("#email_sign #password").val();
				var ce = !!email.match("^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$");
			  	var name = email.split('@');

			  	if(ce == true){
					$.post(
						EMAIL_SIGNUP_URL,{
							email	: email,
							pwd		: pwd,
							name	: name[0]
						},function(data){
							alert(data);
						}
					)
				}else{
					alert("请填入正确的邮箱地址");
				}
			}
		}
  </script>
 </body>
</html>