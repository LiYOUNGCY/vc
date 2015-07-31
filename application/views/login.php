<body style="height:100%;overflow: hidden;">
<?=$sidebar ?>
<div id="vi_container" class="container">
  <div id="loginbg" class="loginbg"></div>
  <div id="shade"></div>
  <div id="sbtn" class="sbtn">
    <div class="icon sidebtn"></div>
  </div>
  <div id="vl_content" class="content">
    <div class="loginlogo">
      <a class="link" href="<?=base_url()?>">
        <div class="icon logo-w"></div>
      </a>
      <span class="text">
        <a href="" class="link"> <b>艺术维C</b>
        </a>
        <br />
        affecting the life in a mysterious way
      </span>
    </div>
    <div class="logtext">
      <div class="float-l"> <font class="big">欢迎登陆</font> <font style="font-size:70%;text-decoration: underline;font-weight:bold;"><a class="link" href="<?=base_url()?>signup">注册账号</a></font> 
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
            <div class="loginbtn btn">登陆</div>
          </a>
        </div>
        <div class="width-100p loginoption" style="display:inline-block">
          <div class="remember">
            <input type="checkbox" value="1" id="rememberme" name="" style="display:none;" />
            <label for="rememberme"></label>
          </div>
          <div class="text float-l">
            <label for="rememberme">下次自动登录</label>
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
            <a class="link" href="#">用户协议</a>
            &nbsp;-&nbsp;
            <a class="link" href="#">隐私政策</a>
            &nbsp;-&nbsp;
            <a class="link" href="#">联系我们</a>
            &nbsp;-&nbsp;
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
    var is_remember = $("#rememberme").prop("checked");
    if(is_remember == true) is_remember = 1; else is_remember = 0;
    
    if( ce == true ){
        $.post(
        EMAIL_LOGIN_URL,{
          email : username,
          pwd     : password,
          rememberme : is_remember
        },function(data){
          data = eval('('+data+')');
          if(data.error != null)
          {
            ERROR_OUTPUT(data);
            return false;
          }
          else if(data.success == 0)
          {
             eval(data.script);
          }
        }
      )
    }
    else if( cp == true ){
        $.post(
        PHONE_LOGIN_URL,{
          phone  : username,
          pwd    :  password,
          rememberme : is_remember
        },function(data){
          data = eval('('+data+')');
          if(data.error != null)
          {
            ERROR_OUTPUT(data);
            return false;
          }
          else if(data.success == 0)
          {
             eval(data.script);
          }
        }
      )
    }

  }
  </script>
</body>
</html>