<body>
<div class="main-wrapper">
    <!-- 顶部 -->
    <?php echo $top; ?>
    <!-- 主体 -->
    <div class="container">
        <div class="personal">
            <div class="userinfo clearfix">
                <div class="uhead">
                    <img src="<?= $user['pic'] ?>">
                </div>
                <div class="info">
                    <ul>
                        <li><label>昵称</label>：<?= $user['name'] ?></li>
                        <li><label>收货地址</label>：<?php echo 1 ? '空' : $user['address']; ?></li>
                        <li><label>联系电话</label>：<?php echo 1 ? '空' : $user['tel']; ?></li>
                        <li><label>联系人</label>：</li>
                    </ul>
                    <a href="<?= base_url() ?>setting">
                        <div class="editinfo btn">修改信息</div>
                    </a>
                </div>
            </div>
            <div class="ptitle">
                个人中心
            </div>
            <div class="pmenu">
                <ul>
                    <li>
                        <a href="<?= base_url() ?>like">
                            <div class="icon plike"></div>
                            <div class="mt">我的喜欢</div>
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url() ?>transaction">
                            <div class="icon pbuyed"></div>
                            <div class="mt">购买记录</div>
                        </a>
                    </li>
                    <li class="tc">
                        <a href="<?= base_url() ?>cart">
                            <div class="icon pcart"></div>
                            <div class="mt">购物车</div>
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url() ?>msg">
                            <div class="icon pmsg"></div>
                            <div class="mt">信息</div>
                        </a>
                    </li>
                    <li class="active">
                        <a href="javascript:void(0);">
                            <div class="icon psetting"></div>
                            <div class="mt">安全设置</div>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="safesettig clearfix ">
                <div class="setpwd">
                    <div class="type">修改密码</div>
                    <label for="olepwd">旧密码</label>
                    <input id="olepwd" name="olepwd" type="text">
                    <div class="error_div" id="olepwd_error">旧密码错误</div>
                    <label for="newpwd">新密码</label>
                    <input id="newpwd" name="newpwd" type="text">
                    <div class="error_div" id="newpwd_error"></div>
                    <label for="conpwd">确认新密码</label>
                    <input id="conpwd" name="conpwd" type="text">
                    <div class="error_div" id="conpwd_error">两次密码不对</div>
                    <div class="btn" id="submitpwd">确认修改</div>
                </div>
                <div class="setaccount">
                    <div class="type">账号绑定</div>
                    <div class="bindphone">
                        <div class="phone">
                            <label >已绑定手机号码</label>
                            <?php if ($user['phone'] == null) {
    ?>
                            无<a href="javascript:void(0);" class="link" id="bindphone"> [绑定手机]</a>
                            <?php 
} else {
    ?>
                            <?=$user['phone']?><a href="javascript:void(0);" class="link" id="bindphone"> [重新绑定]</a>
                            <?php 
} ?>
                        </div>
                    </div>
                    <div class="bindemail">
                        <div class="email">
                            <label >已绑定邮箱</label>
                            <?php if ($user['email'] == null) {
    ?>
                            无<a href="javascript:void(0);" class="link" id="bindemail"> [绑定邮箱]</a>
                            <?php 
} else {
    ?>
                            <?=$user['email']?><a href="javascript:void(0);" class="link" id="bindemail"> [重新绑定]</a>
                            <?php 
} ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php echo $footer; ?>
</div>
<script type="text/javascript" src="<?= base_url() ?>public/js/swiper.min.js"></script>
</body>
<script>
    $(function () {
        $('#conpwd_error').hide();
        $('#olepwd_error').hide();

        var phone_code = '';

        $("#bindphone").click(function(){
            var elem = '' +
            '<label for="phone">输入需要绑定的手机</label>' +
            '<input id="phone" name="phone" type="text">' +
                '<div class="error_div" id="phone_error"></div>' +
            '<div class="pinarea">' +
            '<input id="pin" name="pin" class="pin" type="text">' +
            '<duv class="getpin btn" id="getpin">发送验证码</duv></div>' +
                    '<div class="error_div" id="pin_error" style="display: none;">验证码错误</div>' +
            '<div class="btn submitphone" id="submitphone">提交</div>';
            $(".phone").html(elem);


            $('#getpin').click(getpin_event);
            $('#submitphone').click(change_phone);
        });
        $("#bindemail").click(function(){
            var elem = '' +
            '<label for="email">输入需要绑定的邮箱</label>' +
            '<input id="email" name="email" type="text">' +
            '<div class="btn sendpin" id="sendpin">验证邮箱</div>';
            $(".email").html(elem);
        });


        //修改密码
        $('#submitpwd').click(function(){
            //判断重复输入的密码
            var p1 = $('#newpwd').val();
            var p2 = $('#conpwd').val();
            var p  = $('#olepwd').val();

            if(! validate('olepwd', p)) {
                return ;
            }

            if(validate('newpwd', p1)) {
                if(p1 == p2) {
                    $('#conpwd_error').hide();
                    //提交修改密码
                    $.ajax({
                        url:BASE_URL + 'account/setting/change_password',
                        type: 'POST',
                        data : {
                            old_pwd: p,
                            pwd: p1
                        },
                        dataType: 'json',
                        success: function(data) {
                            console.log(data);
                            if(data.error != null) {
                                $('#olepwd_error').html(data.error);
                            }
                            else {
                                //success

                            }
                        }
                    });
                }
                else {
                    $('#conpwd_error').show();
                }
            }
        });


        //绑定手机
        function change_phone(){
            $('#pin_error').hide();
            var pin = $('#pin').val();
            var phone = $('#phone').val();

            if( pin == phone_code && validate('phone', phone)) {
                $.ajax({
                    url: BASE_URL + 'account/setting/change_phone',
                    type: 'post',
                    dataType: 'json',
                    data: {
                        phone: phone
                    },
                    success: function (data) {
                        console.log(data);
                    }
                });
            }
            else if(pin != phone_code) {
                $('#pin_error').show();
            }
        }


        /**
         * 接受验证码
         */
        function getpin_event() {
            $('#pin_error').hide();
            var phone = $('#phone').val();
            if (! validate('phone', phone)) {
                //输出错误
                return ;
            }

            if (!$("#getpin").hasClass("sending")) {
                //ajax 获取验证码
                $.ajax({
                    type: 'POST',
                    url: SEND_PHONE_CODE_URL,
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
                $("#getpin").addClass("sending");
                var waitTime = 10;
                var time = self.setInterval(function () {
                        waitTime--;
                        $("#getpin").html(waitTime + "s");
                        if (waitTime == 0) {
                            window.clearInterval(time);
                            $("#getpin").removeClass("sending");
                            $("#getpin").html("重新发送");
                        }
                    }
                    , 1000);

            }
        }
    });

</script>
</html>
