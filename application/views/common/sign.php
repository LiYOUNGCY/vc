
<!-- 登陆注册 -->
<div class="shade" style="display:none" onclick="hidesign()"></div>
<div class="sign" style="display:none">
    <div class="position" id="position">
        <div class="signin">
            <div class="title">欢迎登录<font>ARTVC</font></div>
            <div class="form">
                <input type="text" name="username" id="username" placeholder="手机号/邮箱" />
                <input type="password" name="password" id="password" class="noborder" placeholder="密码" />
            </div>
            <div class="btn">登录</div>
            <div class="opt">
                <div class="rememberme clearfix">
                    <div class="checkbox">
                        <input type="checkbox" value="1" id="rememberme" name="" style="display:none;" />
                        <label for="rememberme"></label>
                    </div>
                    <label for="rememberme" style="color:#B3B3B3;font-size:14px;cursor:pointer;">下次自动登录</label>
                </div>
                <div class="fogetpwd">
                    <a href="" class="link">忘记密码?</a>
                </div>
            </div>
            <div class="thirdparty">
                第三方登陆：
                <i class="fa fa-qq"></i>
                <i class="fa fa-weibo"></i>
                <i class="fa fa-weixin"></i>
            </div>
            <div class="tosignup" style="border-radius:0 0 5px 5px;" id="tosignup">
                注册 ARTVC 账号
            </div>
        </div>
        <div class="signup">
            <div class="tosignin" style="border-radius:5px 5px 0 0;" id="tosignin">
                登录 
            </div>
            <div class="title" style="margin-top: 35px;">欢迎注册<font>ARTVC</font></div>
            <div class="changesign" id="changesign">
                <a href="javascript:void(0);" class="link" id="toemail">使用邮箱注册</a>
                <a href="javascript:void(0);" class="link" id="tophone" style="display:none">使用手机注册</a>
            </div>
            <div class="form" id="phonesign">
                <input type="tel" name="phone" id="phone" placeholder="手机号" />
                <input type="password" name="password" id="password" placeholder="密码" />
                <input type="tel" name="velidata" id="velidata" class="noborder" placeholder="验证码" />
                <div class="btn sendvelidata" id="sendvelidata" onclick="sendvailidata()">发送验证码</div>
            </div>
            <div class="form" id="emailsign" style="display:none;">
                <input type="email" name="email" id="email" placeholder="邮箱地址" />
                <input type="password" name="password" id="password" class="noborder" placeholder="密码" />
            </div>
            <div class="btn">注册</div>
        </div>    
    </div> 
</div>
<script>
$(function(){
	$("#toemail").click(function() {
		$(this).css({"display":"none"});
		$("#phonesign").css({"display":"none"});
		$("#phonesign input").each(function(i){
		$(this).val("");
		});
		$("#signway").val("email");
		$("#emailsign").css({"display":"block"});
		$("#tophone").css({"display":"block"});
	})

	$("#tophone").click(function() {
		$(this).css({"display":"none"});
		$("#phonesign").css({"display":"block"});
		$("#emailsign input").each(function(i){
		$(this).val("");
		});
		$("#signway").val("phone");
		$("#emailsign").css({"display":"none"});
		$("#toemail").css({"display":"block"});
	})

	$("#tosignin").click(function(){
	    $("#position").animate({
	        top:"0px",
	    },200);
	})
	$("#tosignup").click(function(){
	    $("#position").animate({
	        top:"-348px",
	    },200);
	})
})

function showsign(){
    $(".shade").fadeIn(200);
    $(".sign").fadeIn(200);
}
function hidesign(){
    $(".shade").fadeOut(200);
    $(".sign").fadeOut(200);
}
function sendvailidata(){
    if(!$("#sendvelidata").hasClass("sending")){
        $("#sendvelidata").addClass("sending");
        var waitTime = 10;
        var time = self.setInterval(function() {
                waitTime--;
                $("#sendvelidata").html(waitTime+"s");
                if(waitTime == 0){
                    window.clearInterval(time);
                    $("#sendvelidata").removeClass("sending");
                    $("#sendvelidata").html("重新发送"); 
                }
            }
            ,1000);

    }else{
        return;
    }    
}
</script>