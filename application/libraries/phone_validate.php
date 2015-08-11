<?php
require_once(APPPATH.'third_party/ucpass/Ucpaas.class.php');


class phone_validate
{
    private $appId;
    private $templateId;
    private $param;
    private $options;

    public function __construct()
    {
        $this->CI = & get_instance();
        $this->CI->config->load('third_config');

        $this->appId                    = $this->CI->config->item('ucpass_appId');
        $this->templateId               = $this->CI->config->item('ucpass_templateId');
        $this->options['accountsid']    = $this->CI->config->item('ucpass_option_accountsid');
        $this->options['token']         = $this->CI->config->item('ucpass_option_token');
        $this->param                    = $this->CI->config->item('param');
    }

    /**
     * [send_code 发送手机验证码， 成功返回验证码， 失败返回 NULL]
     */
    public function send_code($phone, $code)
    {
        $ucpass = new Ucpaas($this->options);

        return $ucpass->templateSMS($this->appId, $phone, $this->templateId, $code);
    }
}
