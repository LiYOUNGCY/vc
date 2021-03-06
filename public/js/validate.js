(function (self) {

    //验证正则表达式
    var VALIDATE_RULE = {
        'email': '^\\w+([-+.]\\w+)*@\\w+([-.]\w+)*\\.\\w+([-.]\\w+)*$',
        'area': '^(.){2,28}$',
        'phone': '^\\d{11}$',
        'name': '^(.){2,36}$',
        'alias': '^\\w{3,20}$',
        'pwd': '^(.){8,36}$',
        'sex': '[0|1|2]',
        'birthday': '^\\d{4}-\\d{2}-\\d{2}$',
        'phone_validate_code': '^\\d{4}$',
        'newpwd': '^[^\s]{8,16}$',
        'olepwd': '^[^\s]{8,16}$',
        'contact': '^(.){1,36}$',
        'address': '^(.){1,64}$',
        'confirm_pwd':'^(.){8,36}$',
        'phonenum' : '^\\d{11}$'
    };
    var VALIDATE_ERROR = {
        'format_name': '昵称必须为长度在1~10的字符',
        'format_phone': '手机号码必须为11位',
        'format_sex': '性别必选*',
        'format_alias': '至少3个英文字符，数字，下滑线',
        'format_pwd': '密码长度在8~36',
        'format_confirm_pwd': '密码长度在8~36',
        'format_email': '邮箱格式错误',
        'format_birthday': '格式错误',
        'format_area': '至少两个字',
        'format_phone_validate_code': '验证码长度必须为4位',
        'format_newpwd': '密码长度在8~36，只能含数字，字母，及下划线',
        'format_olepwd': '密码错误',
        'format_contact': '联系人不能为空',
        'format_address': '详细地址不能为空',
        'format_phonenum':'手机号码必须为11位'
    };

    self.validate = function (_formname, value) {
        formname = _formname;
        var $form = $('#' + formname + '_error');

        if (VALIDATE_RULE[formname] != null) {
            rule = VALIDATE_RULE[formname];
            reg = new RegExp(rule);

            //验证失败
            if (!reg.test(value)) {
                if ($form.length == 1) {
                    $form.html(VALIDATE_ERROR['format_' + formname]);
                    $form.css('display', 'block');
                }
                return false;
            }
            //成功
            else {
                if ($form.length == 1) {
                    $form.html('');
                    $form.css('display', 'none');
                }
                return true;
            }
        }
        return true;
    }
}(window));
