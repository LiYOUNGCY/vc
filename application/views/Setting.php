<body onload="setup();preselect('北京市');promptinfo();">
<div class="main-wrapper">
    <!-- 顶部 -->
    <?= $top ?>
    <div class="container">
        <div class="content edit">
            <form class="list" method="post" action="<?= base_url() ?>artist/publish/publish_artist">

                <div class="item">
                    <p><a class="link" href="#">鸡巴白</a> » 修改个人信息</p>
                </div>

                <div class="item line-block">
                    <label for="name">昵称：</label>
                    <input id="name" name="name" type="text">

                    <div class="error_box" id="name_error" style="display:none;"></div>
                </div>

                <div class="item">
                    <div class="radio-box">
                        <p style="display:inline-block; margin-right:10px;">性别：</p>
                        <input class="radiocheck" name="article_type" id="article" type="radio" value="1" checked>
                        <label class="nofull default left" for="article">男</label>
                        <input class="radiocheck" name="article_type" id="topic" type="radio" value="2">
                        <label class="nofull default left" for="topic">女</label>
                    </div>
                </div>

                <div class="item line-block">
                    <label for="evaluation">收货地址：</label>
                    <span>广东省广州市从化区太平镇广从13号华软</span>
                    <a id="edit_address" href="javascript:void(0)" style="display:inline-block;">[ 编辑收货地址 ]</a>
                </div>

                <div class="item line-block">
                    <label for="evaluation">Email：</label>
                    <span>981533089@qq.com</span>
                    <a href="javascript:void(0)" style="display:inline-block;" id="change_email">[ 更换邮箱 ]</a>
                    <span class="introduction">当邮箱改变时，登录的账号也会改变</span>

                    <input class="width-280" type="text" name="email" id="email" style="display:none;">

                    <div class="btn code" style="display:none;">验证邮箱</div>
                    <div class="error_box" id="email_error" style="display:none;"></div>
                </div>

                <div class="item line-block">
                    <label for="evaluation">手机：</label>
                    <span id="phone_msg">15521322924</span>
                    <a id="change_phone" href="javascript:void(0)" style="display:inline-block;">[ 更换手机 ]</a>
                    <span class="introduction">当手机改变时，登录的账号也会改变</span>

                    <input class="width-280" type="text" name="phone" id="phone" style="display:none;">

                    <div class="btn code" style="display:none;" id="phone_code">获取验证码</div>
                    <div class="error_box" id="phone_error" style="display:none;"></div>
                </div>

                <div class="options">
                    <div class="btn cancel" onclick="">取消</div>
                    <div id="save" class="btn save" onclick="alert(document.getElementById('address').value);">保存</div>
                </div>
        </div>
        <?= $footer ?>
    </div>
</div>
<div class="hidediv" style="display:none;" id="phone_div">
    <div class="msg_box">
        <div class="msg_close"><i class="fa fa-close"></i></div>
        <div class="msg_content item">
            <h3 class="title">绑定手机</h3>
            <input type="text" name="phone_validate_code" id="phone_validate_code" placeholder="请输入短信验证码">

            <div class="error_box" id="phone_validate_code_error"></div>

            <p class="message">验证码将在xxx秒后过期</p>

            <div class="options">
                <div id="save" class="btn save">确定</div>
            </div>
        </div>
    </div>
</div>

<div class="hidediv" style="display:none;" id="address_div">
    <div class="msg_box">
        <div class="msg_close"><i class="fa fa-close"></i></div>
        <div class="msg_content item">
            <h3 class="title">编辑收货地址</h3>

            <div style="margin: 10px 0;">
                <select class="select" name="province" id="s1">
                    <option></option>
                </select>
                <select class="select" name="city" id="s2">
                    <option></option>
                </select>
                <select class="select" name="town" id="s3">
                    <option></option>
                </select>
                <input id="address" name="address" type="hidden" value=""/>
            </div>
            <input type="text" name="detail_address" id="detail_address" placeholder="输入详细地址">

            <div class="options">
                <div id="address_save" class="btn save">保存</div>
            </div>
        </div>
    </div>
</div>
</body>
<script type="text/javascript">
    function promptinfo() {
        var address = document.getElementById('address');
        var s1 = document.getElementById('s1');
        var s2 = document.getElementById('s2');
        var s3 = document.getElementById('s3');
        address.value = s1.value + s2.value + s3.value;
        console.log(address.value);
    }

    $(function () {
        function hidediv_open(self) {
            $(self).css('display', 'block');
            // $('body').css('overflow-y', 'hidden');
        }

        function hidediv_close(self) {
            $(self).parent().parent().css('display', 'none');
            // $('body').css('overflow-y', 'auto');
        }

        $('.msg_close').each(function () {
            $(this).click(function () {
                hidediv_close($(this));
            });
        });

        //点击[ 更换手机 ]
        $('#change_phone').click(function () {
            ShowAll($(this));
        });
        //点击[ 更换邮箱 ]
        $('#change_email').click(function () {
            ShowAll($(this));
        });

        //点击获取验证码的事件
        $('#phone_code').click(function () {
            hidediv_open('#phone_div');
        });

        $('#edit_address').click(function () {
            hidediv_open('#address_div');
        });


        //当 input 框失去焦点时
        $('input').each(function () {
            var input = $(this);
            $(this).blur(function () {
                var key = input.attr('name');
                var value = input.val();
                if (key != "" && value != "") {
                    validate(key, value);
                }
                else {
                    console.log("key or value are null");
                }
            });
        });


        function ShowAll($self) {
            var tar = $self.parent();
            tar.find('span').hide();
            tar.find('a').hide();
            tar.find('input').show();
            tar.find('.code').show();
        }
    });
</script>
</html>
