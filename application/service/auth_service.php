<?php 
class Auth_service extends MY_Service
{
	private $login_in_session_name;
	private $remember_me_cookie_name;
    private $token_size;
    private $selector_size;

	public function __construct()
	{
		parent::__construct();
		$this->login_in_session_name 	= 'artvc_lisn';
		$this->remember_me_cookie_name 	= 'rmcn';

        $this->token_size       = 32;
        $this->selector_size    = 16;
        $this->load->model('auth_tokens_model');
        $this->load->helper('cookie');

	}

	public function check_role_auth()
	{

	}

    /**
     * non_login_in 记住密码功能
     * 返回值是 user_id
     */
    public function non_login_in()
    {
        $_userid = $this->_get_session();
        $_cookie = NULL;
        //检查 SESSION
        if ( $_userid )
        {
            return $_userid;
        }
        elseif ( ($_cookie = $this->_get_cookie()) != FALSE )
        {
            $uid = $this->auth_tokens_model->confirm_token($_cookie['selector'], $_cookie['token']);

            if($uid != FALSE)
            {
                //刷新 COOKIE 的 token
                $_cookie = $this->_generate_cookie($_cookie['selector']);
                //更新数据库的 token
                $this->auth_tokens_model->update_token_by_selector($_cookie['selector'], $_cookie['token']);

                $this->set_login_session($uid);
                return $uid;
            }
            //可能 cookie 被纂改过
            else
            {
                //警告信息
                return FALSE;
            }
        }
        //没有登陆过
        else
        {
            return FALSE;
        }
    }

    /**
     * 设置 login 后的 session
     * 登陆后 SESSION 填写 uid
     */
    public function set_login_session($uid)
    {
        $this->_set_session($uid);
    }

    /**
     * 记住密码的 cookie
     */
    public function set_remember_me_cookie($uid)
    {
        $_cookie = $this->_generate_cookie();
        $this->auth_tokens_model->set_token ($uid, $_cookie['selector'], $_cookie['token']);
    }

	private function _get_session()
	{
		return isset( $_SESSION[$this->login_in_session_name] ) ? $_SESSION[$this->login_in_session_name] : FALSE;
	}

	private function _set_session($uid)
	{
		$this->session->set_userdata($this->login_in_session_name, $uid);
	}

    private function _get_cookie()
    {
        $ret = get_cookie($this->remember_me_cookie_name);

        if(! isset($ret) )
        {
            return FALSE;
        }

        $data = array();
        $data['selector']   = substr($ret, 0, $this->selector_size);
        $data['token']      = substr($ret, $this->selector_size);

        return $data;
    }

    private function _generate_cookie($selector = '')
    {
        $factory = new RandomLib\Factory();
        $generator = $factory->getGenerator(new SecurityLib\Strength(SecurityLib\Strength::MEDIUM));

        $token = $generator->generate($this->token_size);
        $token = hash('sha256', $token);

        if( $selector == '') {
            $selector = $generator->generateString($this->selector_size);
        }

        $cookie_value = $selector.$token;
        $this->_set_cookie($cookie_value);
        return array(
            'selector'  => $selector,
            'token'     => $token
        );
    }


    private function _set_cookie($string)
    {
        set_cookie($this->remember_me_cookie_name, $string);
    }
}