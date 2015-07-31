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
      <a class="link" href="javascript:void(0);">
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
      <div class="float-l"> <font class="big">欢迎注册</font> <font style="font-size:70%;text-decoration: underline;font-weight:bold;"><a class="link" href="<?=base_url()?>login">登陆</a></font> 
      </div>
    </div>
    <div class="logform width-100p">
      <div class="formcon">
        <div class="float-r " style="margin-bottom:5px;font-weight:bold;display:none;" id="tophone" >
          <a class="link" href="javascript:void(0);" id="change">使用手机注册</a>
        </div>
        <div class="float-r " style="margin-bottom:5px;font-weight:bold;display:block;" id="toemail">
          <a class="link" href="javascript:void(0);" id="change">使用邮箱注册</a>
        </div>
        <div class="form" id="phone_sign">
          <input type="text" id="phone" placeholder="手机号" />
          <div id="phone_error" class="error_div"></div>          
          <hr style="color:#B3B3B3;" />
          <input type="password" id="pwd" placeholder="密码" />
         
        </div>
        <div class="form" style="display:none;" id="email_sign">
          <input type="text" id="email" placeholder="邮箱地址" />
          <div id="email_error" class="error_div"></div>          
          <hr style="color:#B3B3B3;" />
          <input type="password" id="pwd" placeholder="密码" />
           
        </div>
        <div id="pwd_error" class="error_div"></div>  

        <div class="width-100p">
          <a class="link" href="javascript:signup();">
            <div class="loginbtn btn">注册</div>
          </a>
        </div>

        <input id="signway" type="hidden" value="phone"></div>
    </div>
    <div id="vi_footer" class="width-100p logfooter">
      <div class="vi_footer" style="margin-top:130px">
        <div class="vi_footer_left">
          <div>
            &copy;&nbsp;artvc.cc&nbsp;京ICP备09025489号-4&nbsp;
            <a class="link" href="javascript:void(0);">用户协议</a>
            &nbsp;-&nbsp;
            <a class="link" href="javascript:void(0);">隐私政策</a>
            &nbsp;-&nbsp;
            <a class="link" href="javascript:void(0);">联系我们</a>
            &nbsp;-&nbsp;
            <a class="link" href="javascript:void(0);">意见反馈</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript" src="<?=base_url().'public/'?>js/vchome.js"></script>
<script type="text/javascript" src="<?=base_url()?>public/js/validate.js"></script>
<script type="text/javascript">
  var BASE_URL = $("#BASE_URL").val();
  var EMAIL_SIGNUP_URL = BASE_URL + "account/main/register_by_email";
  var PHONE_SIGNUP_URL = BASE_URL + "account/main/register_by_phone";
  var CHECK_PHONE_URL = BASE_URL + "account/main/check_phone";
  var CHECK_EMAIL_URL = BASE_URL + "account/main/check_email";      
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
    
    $('#phone').blur(function(){
      var result = validate('phone', $('#phone').val());
      if(result)
      {
        check_phone();
      }
    });
    $('#email').blur(function(){
      var result = validate('email', $('#email').val());
      if(result)
      {
        check_email();
      }
    });
    $('#phone_sign #pwd').blur(function(){
      validate('pwd', $('#phone_sign #pwd').val());
    });    
    $('#email_sign #pwd').blur(function(){
      validate('pwd', $('#email_sign #pwd').val());
    });    
    function signup(){ 


        var signup_way = $("#signway").val();
        
        if( signup_way == "phone" ){

        var phone = $("#phone_sign #phone").val();
        var pwd   = $("#phone_sign #pwd").val()
        var phone_result = validate('phone',phone);
        var pwd_result =   validate('pwd',pwd);
        var cp = phone_result && pwd_result && phone_check;

          if(cp == true){

          $.post(
            PHONE_SIGNUP_URL,{
              phone : phone,
              pwd   : pwd
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
        else{
        var email = $("#email_sign #email").val();
        var pwd = $("#email_sign #pwd").val();
        var email_result = validate('email',email);
        var pwd_result =   validate('pwd',pwd);
        var ce = email_result && pwd_result && email_check;

          if(ce == true){
          $.post(
            EMAIL_SIGNUP_URL,{
              email : email,
              pwd   : pwd
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
    }

    var phone_check = true;
    function check_phone()
    {

      var phone = $("#phone").val();
      $.post(CHECK_PHONE_URL,{phone:phone},function(data){
        data = eval('('+data+')');
        if(data.error != null)
        {
          phone_check = false;
          $('#phone_error').html(data.error);          
        }
        else if(data.success == 0)
        {
          phone_check = true;
        }
      });  
    } 

    var email_check = true;
    function check_email()
    {
       var email = $("#email").val();
        $.post(CHECK_EMAIL_URL,{email:email},function(data){
          data = eval('('+data+')');
          if(data.error != null)
          {
            email_check = false;
            $('#email_error').html(data.error);          
          }
          else if(data.success == 0)
          {
            email_check = true;
          }
        });         
    }
  </script>
</body>
</html>