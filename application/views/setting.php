<body onload="setup();preselect('北京市');promptinfo();">
<div class="main-wrapper">
    <!-- 顶部 -->
    <?= $top ?>
    <div class="container">
        <div class="setting">
            <div class="headpic">
                <div class="pic">
                    <img src="<?=$user['pic']?>" alt="" id="headpic">
                </div>
                <div class="drawer">
                    <div class="camera">
                        <i class="fa fa-camera"></i><br>
                        <span class="text">修改头像</span>
                    </div>
                </div>
                <input type="file" class="uploadhead" name="upfile" id="upfile" onchange="fileUpload()">
            </div>
            <div class="editinfo">

                <label for="name">昵称</label>
                <input type="text" value="<?=$user['name']?>" name="name" id="name">
                <div class="error_div" id="name_error"></div>
<!--                <label for="sex">性别</label>-->
                <input type="radio" name="sex" id="male" value="0" checked>男
                <input type="radio" name="sex" id="female" value="1">女

                <label for="address">收货地址</label>
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
                <input type="text" value="" name="address" placeholder="详细地址" id="address">
                <div class="error_div" id="address_error"></div>
                <label for="phone">联系电话</label>
                <input type="text" value="<?=$user['phone']?>" name="phone" id="phone">
                <div class="error_div" id="phone_error"></div>
                <label for="contact">联系人</label>
                <input type="text" value="<?=$user['contact']?>" name="contact" id="contact" placeholder="例如：张三">
                <div class="error_div" id="contact_error"></div>

            </div>
            <div class="opt">
                <div id="submit"  class="btn save">保存</div>
                <div class="btn cancel">取消</div>
            </div>
        </div>
    </div>
    <?= $footer ?>
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
//        function hidediv_open(self) {
//            $(self).css('display', 'block');
//            // $('body').css('overflow-y', 'hidden');
//        }
//
//        function hidediv_close(self) {
//            $(self).parent().parent().css('display', 'none');
//            // $('body').css('overflow-y', 'auto');
//        }
//
//        $('.msg_close').each(function () {
//            $(this).click(function () {
//                hidediv_close($(this));
//            });
//        });

        //当 input 框失去焦点时
        $('input').each(function () {
            var input = $(this);
            $(this).blur(function () {
                var key = input.attr('name');
                var value = input.val();

                validate(key, value);
            });
        });


        //ajax 提交
        $('#submit').click(function(){
            //检查所有值
            var empty = false;
            $('input').each(function(){
                var key = $(this).attr('name');
                var value = $(this).val();
                if(validate(key, value) == false) {
                    empty = true;
                }
            });

            if(empty) {
                return false;
            }

            var name = $('#name').val();
            var sex = $("input[name=\'sex\']:checked").val();
            var phone = $('#phone').val();
            var contact = $('#contact').val();

            var s1 = document.getElementById('s1');
            var s2 = document.getElementById('s2');
            var s3 = document.getElementById('s3');
            var address = $('#address').val();


            $.ajax({
                url: BASE_URL + 'account/setting/update_account',
                type: 'post',
                data: {
                    name: name,
                    sex: sex,
                    phone: phone,
                    contact: contact,
                    province:s1.value,
                    city: s2.value,
                    town: s3.value,
                    address: address
                },
                dataType: 'json',
                success: function(data) {
                    if(data.error == 0) {
                        swal("修改失败", "", "success");
                    }
                    else if(data.success == 0) {
                        swal("修改成功", "", "success");
                    }
                }
            });
        });


//        function ShowAll($self) {
//            var tar = $self.parent();
//            tar.find('span').hide();
//            tar.find('a').hide();
//            tar.find('input').show();
//            tar.find('.code').show();
//        }


    });

    function fileUpload() {
        $.ajaxFileUpload({
            url: BASE_URL + 'publish/image/upload_headpic',
            fileElementId: 'upfile',
            dataType: 'JSON',
            type: 'post',
            success: function (data) {
                console.log(data);
                var src = data.filepath;

                $('#headpic').attr('src', src);
            },
            error: function (data) {
                console.log(data);
            }
        });
    }
</script>
</html>
