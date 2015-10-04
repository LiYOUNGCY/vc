<body onload="setup();preselect('北京市');promptinfo();">
<div class="main-wrapper">
    <!-- 顶部 -->
    <?= $top ?>
    <div class="container">
        <div class="setting">
            <div class="headpic">
                <div class="pic">
                    <img src="<?=$user['pic']?>" alt="">
                </div>
                <div class="drawer">
                    <div class="camera">
                        <i class="fa fa-camera"></i><br>
                        <span class="text">修改头像</span>
                    </div>
                </div>
                <input type="file" class="uploadhead">
            </div>
            <duv class="editinfo">
                
                <label for="name">昵称</label>
                <input type="text" value="<?=$user['name']?>" name="name" id="name">
                <label for="sex">性别</label>
                <input type="radio" name="sex" id="male" value="male">男
                <input type="radio" name="sex" id="female" value="female">女
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
                <label for="phone">联系电话</label>
                <input type="text" value="<?=$user['tel']?>" name="phone" id="tel">
                <label for="name">联系人</label>
                <input type="text" value="" name="name" id="name">
            </duv>
            <div class="opt">
                <div class="btn save">保存</div>
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
