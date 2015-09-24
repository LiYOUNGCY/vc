<?php 

class Auth_service extends MY_Service{

	private $login_in_session_name;
	private $remember_me_cookie_name;
    private $token_size;
    private $selector_size;


	public function __construct()
	{
		parent::__construct();
		$this->load->model('auth_model');
        $this->load->model('auth_tokens_model');
        $this->load->model('user_model');

        $this->login_in_session_name    = 'artvc_lisn';
        $this->remember_me_cookie_name  = 'rmcn';
        $this->token_size       = 32;
        $this->selector_size    = 16;

        $this->load->helper('cookie');        
	}
	
	/**
	 * [check_user_auth 检查用户权限]
	 * @return [type] [description]
	 */
	public function check_user_auth()
	{

		//if(!empty($auths = $this->cache->memcached->get('role_auth')))
        //{
		//	return $this->_is_auth_success($auths);
		//}
		//else
		//{
			$auths = $this->auth_model->get_user_auth(0,NULL);
			$new_auths = array();
			foreach ($auths as $k => $v)
			{
				if( ! empty($v['route']) && ! empty($v['role_group']))
				{
					$new_auths[$v['route']] = $v['role_group'];
				}
			}
			//$this->cache->memcached->save('role_auth',$new_auths,60);
			return $this->_is_auth_success($new_auths);
		//}

	}

	/**
	 * [_is_auth_success 验证权限是否成功]
	 * @param  [type]  $auths [description]
	 * @return boolean        [description]
	 */
	private function _is_auth_success($auths)
	{

		$route = Common::get_route();
		//需权限
		if(array_key_exists($route,$auths))
		{
			$user 	   = isset($_SESSION[$this->login_in_session_name]) ? $_SESSION[$this->login_in_session_name] : NULL;
			$user_role = isset($user['role']) 	  ? $user['role'] 	  : NULL; 
			//有权限
			if(strstr($auths[$route],"|{$user_role}|"))
			{
				return TRUE;
			}
			else
			{

				//有登录权限
				if(strstr($auths[$route],"|1|"))
                {
                    //已登录
                    if( ! empty($user))
                    {
                        return TRUE;                        
                    }
                    //未登录
                    else
                    {
                        $this->error->output('NOTLOGIN_ERROR',array('script' => 'swal({title: "请登录后再进行操作",type: "warning",showCancelButton: true,confirmButtonColor: "#DD6B55",confirmButtonText: "注册/登录",closeOnConfirm: false},function () {showsign();});'));
                    }
                }
                //没有权限   
                $this->error->output('NOAUTH_ERROR',array('script' => 'window.location.href ="'.base_url().'";'));
                		
			}
		}
		//无需权限
		else
		{
			return TRUE;
		}		
	}


    /**
     * non_login_in 记住密码功能
     * 返回值是 user_id
     */
    public function non_login_in()
    {
        $_user_data = $this->_get_session();
        $_cookie = NULL;

        //检查 SESSION
        
        if ( $_user_data !== FALSE )
        {
            return $_user_data;
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

                //查询这个人的信息
                $user_data = $this->user_model->get_login_msg_by_id($uid);

                $this->set_login_session($user_data);

                return $user_data;
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
     * [logout 注销]
     * @return [type] [description]
     */
    public function logout()
    {
        $this->session->unset_userdata($this->login_in_session_name);
        $this->_set_cookie(NULL);   
    }

    /**
     * 设置 login 后的 session
     * 登陆后 SESSION 填写 uid
     */
    public function set_login_session($user_data)
    {
        $this->_set_session($user_data);
    }

    /**
     * 记住密码的 cookie
     */
    public function set_remember_me_cookie($user)
    {
        if(is_array($user)) {
            $uid = $user['id'];
        }
        else {
            $uid = $user;
        }
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

    /**
     * 生成 cookie ，如果传入 selector 就 代表刷新 cookie 的token
     * 否则就是 生成一个全新的 cookie 
     * @param string $selector
     * @return array
     */
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