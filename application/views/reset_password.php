<body>

<div class="main-wrapper">
    <!-- 顶部 -->
    <?php echo $top; ?>
    <!-- 主体 -->
    <div class="container">
        <div class="forgetpwd">
            <h2>重置密码</h2>
            <input type="hidden" name="token" id="token" value="<?= $token ?>">

            <div class="form" style="text-align: left;">
                <input type="password" name="pwd" id="pwd" placeholder="新密码">

                <div class="error_div" id="pwd_error"></div>
            </div>

            <div class="form" style="text-align: left;">
                <input type="password" name="confirm_pwd" id="confirm_pwd" placeholder="确认密码">

                <div class="error_div" id="confirm_pwd_error"></div>
            </div>

            <div class="btn"  id="submit">提交</div>
        </div>
    </div>
    <?php echo $footer; ?>
</div>
<script type="text/javascript" src="<?= base_url() ?>public/js/swiper.min.js"></script>
</body>
<script>
    $(function () {
        $('input[type=password]').each(function () {
            $(this).blur(function () {
                console.log('aaa');
                var formname = $(this).attr('name');
                var value = $(this).val();
                validate(formname, value);
            });
        });
        $('#submit').click(function () {
            var submit_state = true;

            $('input[type=password]').each(function () {
                var formname = $(this).attr('name');
                var value = $(this).val();
                if (!validate(formname, value)) {
                    submit_state = false;
                }
            });
            //检查两次密码相等
            var error_div = $('#confirm_pwd_error');
            if ($('#pwd').val() != $('#confirm_pwd').val()) {
                error_div.html('两次密码不相等');
                error_div.css('display', 'block');
            }
            else {
                error_div.html('');
                error_div.css('display', 'none');
            }

            if (submit_state) {
                console.log('qewreqwr');
                var token = $('#token').val();
                var pwd = $('#pwd').val();
                $.ajax({
                    url: BASE_URL + 'account/main/set_password',
                    type: 'post',
                    data: {
                        token: token,
                        pwd: pwd
                    },
                    dataType: 'json',
                    success: function (data) {
                        if (data.success == 0) {
                            swal({title: "重置密码成功", text: "3秒后跳转到首页", timer: 3000, type: 'success'});
                            setTimeout(function () {
                                window.location.href = BASE_URL + '/home?callback=login';
                            }, 3000)
                        }
                        else if (data.error == 0) {
                            if (data.message != null) {
                                swal("重置密码失败", data.message, "warning")
                            }
                        }
                    }
                });
            }
        });
    })
</script>
</html>
