//验证正则表达式
var VALIDATE_RULE={
    "phone"             :    "^\\d{11}$",
    "username"          :    "^(.){2,36}$",
    "alias"             :    "\\d+",
    "pwd"               :    "^[a-zA-Z0-9_-]{8,36}$",
    "sex"               :    "[0|1]",
    'cancel_reason'     :    ".{1,255}",
    'issue_title'       :    "^(.){1,20}$",
    'issue_content'     :    "^(.){1,100}$",
    'issue_reward'      :    "^[0-9.]{1,8}$",
    'issue_girls_reward':    "^(.){1,20}$",
    'issue_type'        :    "^[0-9]{1,2}$",
    'issue_channel'     :    "(alipay|wx)",
    'payment'           :    "^(.){1,50}$"
};
var VALIDATE_ERROR={
    'format_username'             :            '用户名必须为长度在1~10的字符*',
    'format_phone'                :            '手机号码必须为11位*',
    'format_sex'                  :            '性别必选*',
    'format_alias'                :            '22个英文字符，数字，下滑线',
    'format_pwd'                  :            '密码长度在8~36,不包含特殊字符*',
    'format_confirm_pwd'          :            '两次密码输入不一致',
}


var validate = function(_formname, value, callback){
    formname=_formname;

    if($("#"+formname+"_error").html().length == 0){
        $("#"+formname+"_error").html(VALIDATE_ERROR["format_"+formname]);
    }

    if( VALIDATE_RULE[formname] != null ){
        rule    = VALIDATE_RULE[formname];            
        reg     = new RegExp(rule);

        //验证失败
        if(!reg.test(value)){
            $("#"+formname+"_error").css('display', 'block');
            return false;
        }
        //成功
        else{
            $("#"+formname+"_error").css('display', 'none');
            return true;
        }
    }

    return true;
}

