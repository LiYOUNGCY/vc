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
            <div class="btn" onclick="signin()">登录</div>
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
            <div class="error_div" style="text-align:left;margin-bottom:10px"></div>
            <div class="btn" onclick="signup()">注册</div>
            <input id="signway" type="hidden" value="phone"></div>
    </div>
</div>
<script>
    $(function () {
        var phone_code = '';
        $("#toemail").click(function () {
            $(this).css({"display": "none"});
            $("#phonesign").css({"display": "none"});
            $("#phonesign input").each(function (i) {
                $(this).val("");
            });
            $("#signway").val("email");
            $("#emailsign").css({"display": "block"});
            $("#tophone").css({"display": "block"});
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
        });

        $("#tosignin").click(function () {
            $("#position").animate({
                top: "0px"
            }, 200);
        });
        $("#tosignup").click(function () {
            $("#position").animate({
                top: "-348px"
            }, 200);
        });

        $('#phone').blur(function () {
            var result = validate('phone', $('#phone').val());
            if (result) {
                $(".error_div").html("");
                check_phone();
            } else {
                $(".error_div").html("*请输入正确的手机号码");
            }
        });
        $('#email').blur(function () {
            var result = validate('email', $('#email').val());
            if (result) {
                $(".error_div").html("");
                check_email();
            } else {
                $(".error_div").html("*请输入正确的邮箱地址");
            }
        });


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
            var waitTime = 10;
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
    var phone_check = true;
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

    var email_check = true;
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

        var ce = !!username.match("^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$");
        var cp = !!username.match("^(0|86|17951)?(13[0-9]|15[012356789]|17[678]|18[0-9]|14[57])[0-9]{8}$");
        var is_remember = $("#rememberme").prop("checked");
        if (is_remember == true) is_remember = 1; else is_remember = 0;

        if (ce == true) {
            $.post(
                EMAIL_LOGIN_URL, {
                    email: username,
                    pwd: password,
                    rememberme: is_remember
                }, function (data) {
                    data = eval('(' + data + ')');
                    if (data.error != null) {
                        ERROR_OUTPUT(data);
                        return false;
                    }
                    else if (data.success == 0) {
                        eval(data.script);
                    }
                }
            )
        }
        else if (cp == true) {
            $.post(
                PHONE_LOGIN_URL, {
                    phone: username,
                    pwd: password,
                    rememberme: is_remember
                }, function (data) {
                    data = eval('(' + data + ')');
                    if (data.error != null) {
                        ERROR_OUTPUT(data);
                        return false;
                    }
                    else if (data.success == 0) {
                        eval(data.script);
                    }
                }
            )
        }
    }


    function signup() {
        var signup_way = $("#signway").val();
        console.log(signup_way);

        if (signup_way == "phone") {
            var phone = $("#phonesign #phone").val();
            var pwd = $("#phonesign #password").val();

            var phone_result = validate('phone', phone);
            var pwd_result = validate('pwd', password);

            var cp = phone_result && pwd_result && phone_check
            if (cp == true) {
                console.log(1);
                //检验手机验证码
                var input_phone_code = $('#velidata').val();
                console.log(input_phone_code);
                //验证码不对
                if (phone_code == '' || input_phone_code != phone_code) {
                    //输出错误
                    console.log('验证码错误');
                    return -1;
                }
                $.post(PHONE_SIGNUP_URL, {
                    phone: phone,
                    pwd: pwd
                }, function (data) {
                    data = eval('(' + data + ')');
                    if (data.error != null) {
                        //ERROR_OUTPUT(data);
                        $('.error_div').html(data.error);
                        return false;
                    }
                    else if (data.success == 0) {
                        eval(data.script);
                    }
                })
            }
        } else {
            var email = $("#emailsign #email").val();
            var pwd = $("#emailsign #password").val();
            var email_result = validate('email', email);
            var pwd_result = validate('pwd', password);
            var ce = email_result && pwd_result && email_check;

            if (ce == true) {
                $.ajax({
                    url: EMAIL_SIGNUP_URL,
                    type: 'post',
                    data: {
                        email: email,
                        pwd: pwd
                    },
                    dataType: 'json',
                    success: function (data) {
                        console.log(data);
                        if (data.error != null) {
                            //ERROR_OUTPUT(data);
                            $('.error_div').html(data.error);
                            return false;
                        } else if (data.success == 0) {
                            eval(data.script);
                        }
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            }
        }
    }


</script>