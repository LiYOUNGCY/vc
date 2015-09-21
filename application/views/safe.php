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
                        <li><label>收货地址</label>：<?php echo 1 ? "空" : $user['address']; ?></li>
                        <li><label>联系电话</label>：<?php echo 1 ? "空" : $user['tel']; ?></li>
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
                    <label for="newpwd">新密码</label>
                    <input id="newpwd" name="newpwd" type="text">
                    <label for="conpwd">确认新密码</label>
                    <input id="conpwd" name="conpwd" type="text">
                    <div class="btn" id="submitpwd">确认修改</div>
                </div>
                <div class="setaccount">
                    <div class="type">账号绑定</div>
                    <div class="bindphone">
                        <div class="phone">
                            <label >已绑定手机号码</label>
                            <?php if($user["phone"] == NULL){ ?>
                            无<a href="javascript:void(0);" class="link" id="bindphone"> [绑定手机]</a>
                            <?php }else{ ?>
                            <?=$user["phone"]?><a href="javascript:void(0);" class="link" id="bindphone"> [重新绑定]</a>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="bindemail">
                        <div class="email">
                            <label >已绑定邮箱</label>
                            <?php if($user["email"] == NULL){ ?>
                            无<a href="javascript:void(0);" class="link" id="bindemail"> [绑定邮箱]</a>
                            <?php }else{ ?>
                            <?=$user["email"]?><a href="javascript:void(0);" class="link" id="bindemail"> [重新绑定]</a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php echo $footer; ?>
</div>
<?php
if ($user['role'] == 0) {
    echo $sign;
}
?>
<script type="text/javascript" src="<?= base_url() ?>public/js/swiper.min.js"></script>
</body>
<script>
    $(function () {
        $("#bindphone").click(function(){
            var elem = '' +
            '<label for="phone">输入需要绑定的手机</label>' +
            '<input id="phone" name="phone" type="text">' +
            '<div class="pinarea">' +
            '<input id="pin" name="pin" class="pin" type="text">' +
            '<duv class="getpin btn" id="getpin">发送验证码</duv></div>' +
            '<div class="btn submitphone" id="submitphone">提交</div>';
            $(".phone").html(elem);
        })
        $("#bindemail").click(function(){
            var elem = '' +
            '<label for="email">输入需要绑定的邮箱</label>' +
            '<input id="email" name="email" type="text">' +
            '<div class="btn sendpin" id="sendpin">验证邮箱</div>';
            $(".email").html(elem);
        })
    })

</script>
</html>
