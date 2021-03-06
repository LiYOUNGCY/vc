<body>

<div class="main-wrapper">
    <!-- 顶部 -->
    <?php echo $top; ?>
    <!-- 主体 -->
    <div class="container">
        <div class="forgetpwd">
            <h2>找回密码</h2>

            <div class="btn usephone" onclick="usephone()">使用手机短信找回</div>
            <label>适用于已绑定手机号码的用户</label>

            <div class="btn useemail" onclick="useemail()">使用电子邮箱找回</div>
            <label>适用于已绑定电子邮箱的用户</label>
        </div>
    </div>
    <?php echo $footer; ?>
</div>
<script type="text/javascript" src="<?= base_url() ?>public/js/swiper.min.js"></script>
</body>
<script>
    var phone_code = '';

    function usephone() {
        var elem = '' +
            '<form action="' + BASE_URL + 'account/main/reset_password" method="post">' +
            '<h2>找回密码</h2>' +
            '<div class="form">' +
            '<input type="text" id="phonenum" class="phonenum" placeholder="手机号码" name="phone">' +
            '<div class="error_div" id="phonenum_error"></div>' +
            '<input type="text" id="pinnum" class="pinnum" placeholder="手机验证码" name="code">' +
            '<div class="btn sendvelidata" id="sendvelidata" onclick="sendvailidata()">发送验证码</div>' +
            '</div>' +
            '<div class="btn submit" id="submitphone">提交</div>' +
            '</form>' +
            '<span class="changemethor" onclick="useemail()">使用电子邮箱找回</span>';
        $(".forgetpwd").html(elem);

        $('#submitphone').click(function(){
            var phone = $('#phonenum').val();
            if(validate('phonenum', phone)) {
                $('form').submit();
            }
        });
    }
    function useemail() {
        var elem = '' +
            '<form action="' + BASE_URL + 'account/main/forget_password/email" method="post">' +
            '<h2>找回密码</h2>' +
            '<div class="form">' +
            '<input type="text" id="emailadress" class="emailadress" name="email" placeholder="邮箱地址">' +
            '<div id="email_error" class="error_div"></div>' +
            '</div>' +
            '<div class="btn submit" id="submitemail">提交</div>' +
            '</form>' +
            '<span class="changemethor" onclick="usephone()">使用手机短信找回</span>';
        $(".forgetpwd").html(elem);

        $('#submitemail').click(function () {
            var email = $('#emailadress').val();
            console.log(email);
            if (validate('email', email)) {
                $('form').submit();
            }
        });
    }

    /**
     * 接受验证码
     */
    function sendvailidata() {
        var phone = $('#phonenum').val();
        if (!validate('phonenum', phone)) {
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
</script>
</html>
