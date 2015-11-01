<body>
<div class="main-wrapper">
    <!-- 顶部 -->
    <?php echo $top; ?>
    <!-- 主体 -->
    <div class="container">
        <div class="personal">
            <div class="ptitle">
                个人中心
            </div>
            <div class="pmenu">
                <ul>
                    <li class="active">
                        <a href="javascript:void(0);">
                            <div class="icon psetting"></div>
                            <div class="mt">账户设置</div>
                        </a>
                    </li>
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
                </ul>
            </div>
            <div class="setting">
                <div class="psubmenu">
                    <div><a href="<?= base_url() ?>setting">账户设置</a></div>
                    &nbsp; / &nbsp;
                    <div class="active">安全设置</div>
                </div>
                <div class="safesettig">
                    <div class="item">
                        <label >邮箱</label>
                        <?php if ($user['email'] == null) { ?>
                        <a href="javascript:void(0);" class="link" id="bindemail"> 绑定邮箱</a>
                        <?php } else { ?>
                        <?=$user['email']?><a href="javascript:void(0);" class="link" id="bindemail"> 修改</a>
                        <?php } ?>
                    </div>
                    <div class="item">
                        <label >手机</label>
                        <?php if ($user['phone'] == null) { ?>
                            <a href="javascript:void(0);" class="link" id="bindphone">绑定手机</a>
                        <?php } else { ?>
                            <?=$user['phone']?><a href="javascript:void(0);" class="link" id="bindphone"> 修改</a>
                        <?php } ?>
                    </div>
                    <div class="item">
                        <label >账号密码</label>
                        <a href="javascript:void(0);" class="link" id="updatepwd">修改密码</a>
                    </div>
                    <!-- <div class="setaccount">
                        <div class="type">账号绑定</div>
                        <div class="item">
                            <div class="phone">
                                <label >手机号码：</label>
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
                        <div class="item">
                            <div class="email">
                                <label >邮箱：</label>
                                <?php if ($user['email'] == null) {
        ?>
                                无<a href="javascript:void(0);" class="link" id="bindemail"> [绑定邮箱]</a>
                                <?php 
    } else {
        ?>
                                <?=$user['email']?><a href="javascript:void(0);" class="link" id="bindemail"> 修改</a>
                                <?php 
    } ?>
                            </div>
                        </div>
                    </div>
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
                    </div> -->
                </div>
            </div>
            
        </div>
    </div>
    <?php echo $footer; ?>
    <!-- 绑定邮箱模态框 -->
    <div class="modal bindemail" style="display:none">
        <div class="box">
            <label for="email">需要绑定的邮箱：</label>
            <input type="text" value="" name="email" id="email">
            <div class="error_div" id="email_error"></div>
            <div class="opt">
                <div class="btn cancel">取消</div>
                <div class="btn">发送验证码</div>
            </div>
        </div>
    </div>
    <!-- 绑定手机模态框 -->
    <div class="modal bindphone" style="display:none">
        <div class="box">
            <label for="phone">手机号码：</label>
            <input type="text" value="" name="phone" id="phone">
            <div class="error_div" id="phone_error"></div>
            <label for="verify">验证码：</label>
            <input type="text" value="" name="verify" id="verify">
            <span class="sendverify"><a href="javascript:void(0)" class="link send">发送验证码</a></span>
            <div class="opt">
                <div class="btn cancel">取消</div>
                <div class="btn">提交</div>
            </div>
        </div>
    </div>
    <!-- 修改密码模态框 -->
    <div class="modal updatepwd" style="display:none">
        <div class="box">
            <label for="opwd">旧密码：</label>
            <input type="text" value="" name="opwd" id="opwd">
            <label for="npwd">新密码：</label>
            <input type="text" value="" name="npwd" id="npwd">
            <label for="cnpwd">确认新密码：</label>
            <input type="text" value="" name="cnpwd" id="cnpwd">
            <div class="opt">
                <div class="btn cancel">取消</div>
                <div class="btn">保存</div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?= base_url() ?>public/js/swiper.min.js"></script>
</body>
<script>
    $(function () {
        $('#conpwd_error').hide();
        $('#olepwd_error').hide();

        var phone_code = '';

        $("#bindphone").click(function(){
            $(".bindphone").css({"display":"block"})
        });
        $("#bindemail").click(function(){
            $(".bindemail").css({"display":"block"})
        });
        $("#updatepwd").click(function(){
            $(".updatepwd").css({"display":"block"})
        })

        $(".modal .cancel").each(function(){
            $(this).click(function(){
                $(this).parent().parent().parent().css({"display":"none"});
            })
        })

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
