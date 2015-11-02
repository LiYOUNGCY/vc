<body onload="setup();preselect('北京市');promptinfo();">
<div class="main-wrapper">
    <!-- 修改地址 -->
    <div class="modal editaddress" style="display:none;">
        <div class="box">
            <label for="address">* 收货地址</label>
            <div style="margin:10px 0;">
                <select class="select" name="province" id="s1">
                    <option></option>
                </select>
                <select class="select" name="city"< id="s2">
                    <option></option>
                </select>
                <select class="select" name="town" id="s3">
                    <option></option>
                </select>
                <input id="address" name="address" type="hidden" value=""/>
            </div>
<<<<<<< HEAD
            <input type="text" value="" name="address" placeholder="详细地址" id="address">
=======
            <input type="text" value="" name="ad" placeholder="详细地址" id="ad">
>>>>>>> 2aad3e358d1e2d015d55bcf575362ef69de9cd77
            <div class="error_div" id="address_error"></div>
            <label for="contact">* 收件人</label>
            <input type="text" value="" name="contact" id="contact" placeholder="例如：张三">
            <div class="error_div" id="contact_error"></div>
            <label for="phone">* 联系电话</label>
            <input type="text" value="" name="phone" id="phone">
            <div class="error_div" id="phone_error"></div>
            <div class="opt">
                <div class="btn cancel">取消</div>
<<<<<<< HEAD
                <div class="btn save">保存</div>    
=======
                <div class="btn save" id="save_address">保存</div>
>>>>>>> 2aad3e358d1e2d015d55bcf575362ef69de9cd77
            </div>
        </div>
    </div>
    <!-- 顶部 -->
    <?= $top ?>
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
                    <div class="active">账户设置</div>
                    &nbsp; / &nbsp;
                    <div><a href="<?= base_url() ?>setting/safe">安全设置</a></div>
                </div>
                <div class="baseinfo">
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
<<<<<<< HEAD
                    </div>    
                    <div class="editinfo">
                        <div class="item">
                            <label for="name">昵称：</label><span class="name">1212121</span>
                            <a href="javascript:void(0)" id="changenick" class="link fs-14">[ 修改昵称 ]</a>    
=======
                    </div>
                    <div class="editinfo">
                        <div class="item">
                            <label for="name">昵称：</label><span class="name"><?=$user['name']?></span>
                            <a href="javascript:void(0)" id="changenick" class="link fs-14">[ 修改昵称 ]</a>
>>>>>>> 2aad3e358d1e2d015d55bcf575362ef69de9cd77
                        </div>
                        <label>收货信息：</label>
                        <div class="addressinfo">
                            <!-- 暂无收信息，您可以 <a href="javascript:void(0)" class="link">添加收货信息</a>。 -->
                            <div class="item">
                                <label for="name">收货地址：</label>
<<<<<<< HEAD
                                <span >广东省 广州市 天河区 高德置地A栋2座1201广东省 </span>    
                            </div>
                            <div class="item">
                                <label for="">联系电话：</label>
                                <span>12345678987</span>    
                            </div>
                            <div class="item">
                                <label for="">收货人：</label>
                                <span>灼神</span>    
                            </div>
                            <a href="javascript:void(0)" class="link changeadress">[ 修改收货信息 ]</a>
                        </div>
                        
=======
                                <span ><?=$address['address']?></span>
                            </div>
                            <div class="item">
                                <label for="">联系电话：</label>
                                <span><?=$address['phone']?></span>
                            </div>
                            <div class="item">
                                <label for="">收货人：</label>
                                <span><?=$address['contact']?></span>
                            </div>
                            <a href="javascript:void(0)" class="link changeadress">[ 修改收货信息 ]</a>
                        </div>

>>>>>>> 2aad3e358d1e2d015d55bcf575362ef69de9cd77
                        <!-- <label for="address">收货地址</label>
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
                        <input type="text" value="" name="phone" id="phone">
                        <div class="error_div" id="phone_error"></div>
                        <label for="contact">联系人</label>
                        <input type="text" value="" name="contact" id="contact" placeholder="例如：张三">
                        <div class="error_div" id="contact_error"></div> -->
                    </div>
                </div>
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
        return address.value + $('#ad').val();
    }

    $(function () {
        var base_nick_name = "";

        //当 input 框失去焦点时
        $('input').each(function () {
            var input = $(this);
            $(this).blur(function () {
                var key = input.attr('name');
                var value = input.val();

                validate(key, value);
            });
        });

        //修改昵称
        $("#changenick").click(function(){
            changenick();
        });

        //弹出收起修改地址框
        $(".changeadress").click(function(){
            $(".editaddress").css({"display":"block"});
        })
        $(".editaddress .cancel").click(function(){
<<<<<<< HEAD
            $(".editaddress").css({"display":"none"});  
=======
            $(".editaddress").css({"display":"none"});
>>>>>>> 2aad3e358d1e2d015d55bcf575362ef69de9cd77
        })

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
        function changenick(){
            base_nick_name = $("#changenick").parent().find(".name").html();
            var elem =  '' +
<<<<<<< HEAD
            '<label for="name">昵称：</label>' + 
            '<input type="text" value="'+ base_nick_name +'" name="name" id="name">' + 
            '<div class="nickopt"><div class="btn " id="savenick">保存</div>' +
            '<div class="btn " id="cancel_changenick">取消</div></div>' +
            '<div class="error_div" id="name_error"></div>';
            
=======
            '<label for="name">昵称：</label>' +
            '<input type="text" value="'+ base_nick_name +'" name="name" id="name">' +
            '<div class="nickopt"><div class="btn " id="savenick">保存</div>' +
            '<div class="btn " id="cancel_changenick">取消</div></div>' +
            '<div class="error_div" id="name_error"></div>';

>>>>>>> 2aad3e358d1e2d015d55bcf575362ef69de9cd77
            $("#changenick").parent().html(elem);

            $("#name").blur(function () {
                var value = $("#name").val();
                validate('name', value);
            });

            $("#cancel_changenick").click(function(){
                cancel_changenick();
<<<<<<< HEAD
            })
=======
            });

            $("#savenick").click(function(){
                var name = $('#name').val();
                console.log(name);

                $.ajax({
                    url: BASE_URL + 'account/setting/change_name',
                    type: 'post',
                    data: {
                        name: name
                    },
                    dataType: 'json',
                    success: function(data){
                        console.log(data);
                        if(data.success == 0) {
                            swal("修改成功", "", "success");
                            base_nick_name = name;
                            cancel_changenick();
                        }
                        else if(data.error == 0) {
                            swal("修改失败", "", "warning");
                        }
                    }
                });
            });
>>>>>>> 2aad3e358d1e2d015d55bcf575362ef69de9cd77
        }
        function cancel_changenick(){
            var base_elem = ''+
                '<label for="name">昵称：</label><span class="name">'+ base_nick_name +'</span>' +
                '<a href="javascript:void(0)" id="changenick" class="link fs-14">[ 修改昵称 ]</a>'
<<<<<<< HEAD
            
=======

>>>>>>> 2aad3e358d1e2d015d55bcf575362ef69de9cd77
            $("#cancel_changenick").parent().parent().html(base_elem);
            $("#changenick").click(function(){
                changenick();
            });
        }
<<<<<<< HEAD
=======

        $('#save_address').click(function(){
            //检查所有值
            var empty = true;
            $('.modal').find('input[type=text]').each(function () {
                var input = $(this);
                var key = input.attr('name');
                var value = input.val();
                console.log(value);
                if(validate(key, value) == false) {
                    empty = false;
                }
            });

            if(! empty) {
                return false;
            }
            var address = promptinfo();
            var phone = $('#phone').val();
            var contact = $('#contact').val();
            console.log(address + phone + contact);

            $.ajax({
                url: BASE_URL + 'account/main/set_address',
                type: 'post',
                data: {
                    address: address,
                    phone: phone,
                    contact: contact
                },
                dataType: 'json',
                success: function(data){
                    // console.log(data);
                    if(data.success == 0) {
                        window.location.reload();
                    }
                }
            });
        });
>>>>>>> 2aad3e358d1e2d015d55bcf575362ef69de9cd77

    });

    function fileUpload() {
        $.ajaxFileUpload({
            url: BASE_URL + 'account/setting/change_headpic',
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
