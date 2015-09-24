(function (self) {

    //验证正则表达式
    var VALIDATE_RULE = {
        "email": "^\\w+([-+.]\\w+)*@\\w+([-.]\w+)*\\.\\w+([-.]\\w+)*$",
        'area': "^(.){2,28}$",
        "phone": "^\\d{11}$",
        "name": "^(.){2,36}$",
        "alias": "^\\w{3,20}$",
        "pwd": "^(.){8,36}$",
        "sex": "[0|1|2]",
        "birthday": "^\\d{4}-\\d{2}-\\d{2}$",
        "phone_validate_code": "^\\d{6}$"
    }
    var VALIDATE_ERROR = {
        'format_name': '昵称必须为长度在1~10的字符*',
        'format_phone': '手机号码必须为11位*',
        'format_sex': '性别必选*',
        'format_alias': '至少3个英文字符，数字，下滑线',
        'format_pwd': '密码长度在8~36',
        'format_confirm_pwd': '两次密码输入不一致',
        "format_email": '格式错误',
        "format_birthday": "格式错误",
        "format_area": "至少两个字",
        'format_phone_validate_code': "验证码长度必须为6位"
    }

    self.validate = function (_formname, value) {
        console.log(_formname + " " + value);
        formname = _formname;
        if (VALIDATE_RULE[formname] != null) {
            rule = VALIDATE_RULE[formname];
            reg = new RegExp(rule);

            //验证失败
            if (!reg.test(value)) {
                $("#" + formname + "_error").html(VALIDATE_ERROR["format_" + formname]);
                $("#" + formname + "_error").css('display', 'block');
                return false;
            }
            //成功
            else {
                $("#" + formname + "_error").html("");
                $("#" + formname + "_error").css('display', 'none');
                return true;
            }
        }

        return true;
    }
}(window));
