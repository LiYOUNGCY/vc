<!-- 登陆注册 -->
<div class="shade" style="display:none" onclick="hidesign()"></div>
<div class="sign" style="display:none">
    <div class="position" id="position">
        <div class="signin">
            <div class="title">欢迎登录<font>ARTVC</font></div>
            <div class="form">
                <input type="text" name="username" id="username" placeholder="手机号/邮箱"/>
                <input type="password" name="password" id="password" class="noborder" placeholder="密码"/>
            </div>
            <div class="btn" id="signinbtn" onclick="signin()">登录</div>
            <div class="error_div" id="signinError" style="text-align:left;"></div>
            <div class="opt">
                <div class="rememberme clearfix">
                    <div class="checkbox">
                        <input type="checkbox" value="1" id="rememberme" name="" style="display:none;"/>
                        <label for="rememberme"></label>
                    </div>
                    <label for="rememberme" style="color:#B3B3B3;font-size:14px;cursor:pointer;">下次自动登录</label>
                </div>
                <div class="fogetpwd">
                    <a href="<?=base_url()?>account/forget" class="link">找回密码?</a>
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
                <input type="tel" name="phone" id="phone" placeholder="手机号"/>
                <input type="password" name="password" id="password" placeholder="密码"/>
                <input type="tel" name="velidata" id="velidata" class="noborder" placeholder="验证码"/>

                <div class="btn sendvelidata" id="sendvelidata" onclick="sendvailidata()">发送验证码</div>
            </div>
            <div class="form" id="emailsign" style="display:none;">
                <input type="email" name="email" id="email" placeholder="邮箱地址"/>
                <input type="password" name="password" id="password" class="noborder" placeholder="密码"/>
            </div>
            <div class="error_div" id="signupError" style="text-align:left;margin-bottom:10px"></div>
            <div class="btn" onclick="signup()" id="signupbtn">注册</div>
            <input id="signway" type="hidden" value="phone"></div>
    </div>
</div>
<script>
    var phone_code = '';
    $(function () {

        $("#toemail").click(function () {
            $(this).css({"display": "none"});
            $("#phonesign").css({"display": "none"});
            $("#phonesign input").each(function (i) {
                $(this).val("");
            });
            $("#signway").val("email");
            $("#emailsign").css({"display": "block"});
            $("#tophone").css({"display": "block"});
            $("#signupError").html("");
        });

        $("#tophone").click(function () {
            $(this).css({"display": "none"});
            $("#phonesign").css({"display": "block"});
            $("#emailsign input").each(function (i) {
                $(this).val("");
            });
            $("#signway").val("phone");
            $("#emailsign").css({"display": "none"});
            $("#toemail").css({"display": "block"});
            $("#signupError").html("");
        });

        $("#tosignin").click(function () {

            $("#position").animate({
                top: "0px"
            }, 200);
            $("#signupError").html("");
                $(".sign").find("input").each(function (i) {
                $(this).val("");
            });
        });
        $("#tosignup").click(function () {

            $("#position").animate({
                top: "-348px"
            }, 200);
            $("#signinError").html("");
                $(".sign").find("input").each(function (i) {
                $(this).val("");
            });
        });

        $('#username').blur(function(){
            var cp = validate('phone', $('#username').val());
            var ce = validate('email', $('#username').val());
            if(!cp && !ce){
                $("#signinError").html("* 请输入正确的用户名");
            }else{
                $("#signinError").html("");
            }
        })

        $('#phone').blur(function () {
            var result = validate('phone', $('#phone').val());
            if (result) {
                $("#signupError").html("");
                check_phone();
            } else {
                $("#signupError").html("* 请输入正确的手机号码");
            }
        });
        $('#email').blur(function () {
            var result = validate('email', $('#email').val());
            if (result) {
                $("#signupError").html("");
                check_email();
            } else {
                $("#signupError").html("* 请输入正确的邮箱地址");
            }
        });

        (function(){
            var callback = getQueryString('callback');

            if(callback != null && callback == 'login') {
                showsign(1);
            }

        })();
    });

    function showsign(type) {
        if (type == 1) {
            $(".sign .position").css({"top": 0});
        } else if (type == 2) {
            $(".sign .position").css({"top": "-348px"});
        }
        $(".shade").fadeIn(200);
        $(".sign").fadeIn(200);
    }
    function hidesign() {
        $(".shade").fadeOut(200);
        $(".sign").fadeOut(200);
        $(".sign").find("input").each(function (i) {
            $(this).val("");
        });
        $("#signupError").html("");
        $("#signinError").html("");
    }

    /**
     * 接受验证码
     */
    function sendvailidata() {
        var phone = $('#phonesign #phone').val();
        if (phone == '' || phone == null) {
            //输出错误
            return -1;
        }

        //ajax 获取验证码
        $.ajax({
            type: 'POST',
            url: SEND_PHONE_CODE_URL,
            async: false,
            data: {
                phone: phone
            },
            dataType: 'json',
            success: function (data) {
                console.log(data);
                phone_code = data.code;
                console.log('phone_code: ' + phone_code);
            }
        });

        if (!$("#sendvelidata").hasClass("sending")) {
            $("#sendvelidata").addClass("sending");
            var waitTime = 60;
            var time = self.setInterval(function () {
                    waitTime--;
                    $("#sendvelidata").html(waitTime + "s");
                    if (waitTime == 0) {
                        window.clearInterval(time);
                        $("#sendvelidata").removeClass("sending");
                        $("#sendvelidata").html("重新发送");
                    }
                }
                , 1000);

        } else {
            return;
        }
    }
    var phone_check = false;
    function check_phone() {
        var phone = $("#phone").val();
        $.post(CHECK_PHONE_URL, {phone: phone}, function (data) {
            data = eval('(' + data + ')');
            if (data.error != null) {
                phone_check = false;
                $('.error_div').html(data.error);
            }
            else if (data.success == 0) {
                phone_check = true;
            }
        });
    }

    var email_check = false;
    function check_email() {
        var email = $("#email").val();
        $.post(CHECK_EMAIL_URL, {email: email}, function (data) {
            data = eval('(' + data + ')');
            if (data.error != null) {
                email_check = false;
                $('.error_div').html(data.error);
            }
            else if (data.success == 0) {
                email_check = true;
            }
        });
    }

    function signin() {

        var username = $("#username").val();
        var password = $("#password").val();

        if($("#signinError").html() != "" || username == ""){
            return ;
        }

        $("#signinbtn").attr("class","disable");
        $("#signinbtn").html('<i class="fa fa-spinner fa-pulse"></i> 登录中');


        var cp = validate('phone', $('#username').val());
        var ce = validate('email', $('#username').val());

        var is_remember = $("#rememberme").prop("checked") ? 1 : 0;

        if (ce == true) {
            $.ajax({
                type: 'post',
                url: EMAIL_LOGIN_URL,
                async: false,
                data: {
                    'email'         : username,
                    'pwd'           : password,
                    'rememberme'    : is_remember
                },
                dataType: 'json',
                success: function (data){
                    if (data.error != null || data.length === 0) {
                        $("#signinError").html(data.error);
                        $("#signinbtn").attr("class","btn");
                        $("#signinbtn").html('登录');

                        return;
                    }else if (data.success == 0) {
                        eval(data.script);
                    }
                }
            })
        }
        else if (cp == true) {
            $.ajax({
                type: 'post',
                url: PHONE_LOGIN_URL,
                async: false,
                data: {
                    'phone'         : username,
                    'pwd'           : password,
                    'rememberme'    : is_remember
                },
                dataType: 'json',
                success: function (data){
                    if (data.error != null || data.length === 0) {
                        $("#signinError").html(data.error);
                        $("#signinbtn").attr("class","btn");
                        $("#signinbtn").html('登录');
                        return;
                    }else if (data.success == 0) {
                        eval(data.script);
                    }
                }
            })
        }
    }


    function signup() {
        var signup_way = $("#signway").val();

        if (signup_way == "phone") {

            var phone = $("#phonesign #phone").val();
            var pwd = $("#phonesign #password").val();

            var phone_result = validate('phone', phone);
            var pwd_result = validate('pwd', pwd);

            var cp = phone_result && pwd_result && phone_check ;

            if(!pwd_result){
                $("#signupError").html("密码长度在8~36位");
            }else if(!phone_check){
                $("#signupError").html("该手机已被注册");
            }else if(!phone_result){
                $("#signupError").html("* 请输入正确的手机号码");
            }else{
                $("#signupError").html("");
            }

            if($("#signinError").html() != "" || phone == ""){
                return ;
            }

            $("#signupbtn").attr("class","disable");
            $("#signupbtn").html('<i class="fa fa-spinner fa-pulse"></i> 注册中');


            if (cp == true) {

                //检验手机验证码
                var input_phone_code = $('#velidata').val();
                //验证码不对

                if (phone_code == '' || input_phone_code != phone_code || input_phone_code == '') {
                    //输出错误
                    alert(3);
                    $('#signupError').html("验证码错误");
                    $("#signupbtn").attr("class","btn");
                    $("#signupbtn").html('注册');
                    return -1;
                }

                $.ajax({
                    type: 'post',
                    url: PHONE_SIGNUP_URL,
                    async: false,
                    data: {
                        'phone'   : phone,
                        'pwd'     : pwd
                    },
                    dataType: 'json',
                    success: function (data){
                        if (data.error != null || data.length === 0) {
                            $('#signupError').html(data.error);
                            $("#signupbtn").attr("class","btn");
                            $("#signupbtn").html('注册');
                            return;
                        }else if (data.success == 0) {
                            eval(data.script);
                        }
                    }
                })
            }else{

                $("#signupbtn").attr("class","btn");
                $("#signupbtn").html('注册');
            }
        } else {
            var email = $("#emailsign #email").val();
            var pwd = $("#emailsign #password").val();

            var email_result = validate('email', email);
            var pwd_result = validate('pwd', password);

            var ce = email_result && pwd_result && email_check;

            if(!pwd_result){
                $("#signupError").html("密码长度在8~36位");
            }else if(!email_check){
                $("#signupError").html("该邮箱已被注册");
            }else if(!email_result){
                $("#signupError").html("* 请输入正确的邮箱地址");
            }else{
                $("#signupError").html("");
            }

            if($("#signinError").html() != "" || phone == ""){
                return ;
            }

            $("#signupbtn").attr("class","disable");
            $("#signupbtn").html('<i class="fa fa-spinner fa-pulse"></i> 注册中');

            if (ce == true) {
                $.ajax({
                    type: 'post',
                    url: EMAIL_SIGNUP_URL,
                    async: false,
                    data: {
                        'email'   : email,
                        'pwd'     : pwd
                    },
                    dataType: 'json',
                    success: function (data){
                        if (data.error != null || data.length === 0) {
                            $('#signupError').html(data.error);
                            $("#signupbtn").attr("class","btn");
                            $("#signupbtn").html('注册');
                            return;
                        }else if (data.success == 0) {
                            eval(data.script);
                        }
                    }
                })
            }
        }
    }


</script>
