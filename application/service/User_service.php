<?php defined('BASEPATH') OR exit('No direct script access allowed');


class User_service extends MY_Service
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
		$this->load->service('auth_service');
	}


	/**
	 * [register_action 用户注册]
	 */
	public function register_action($name, $pwd, $email, $phone)
	{
		$register_type = array();
		if( !empty($phone) )
		{
			$register_type['phone'] = $phone;
		}
		else if( !empty($email) )
		{
			$register_type['email'] = $email;
		}
		else 
		{
			//错误
			return FALSE;
		}
		
		//注册成功，设置 session
		if ( $user_id = $this->user_model->register_action ($name, $register_type, $pwd) != FALSE ) {
			$user = $this->user_model->get_user_base_id($user_id);
			//设置 SESSION
			$this->auth_service->set_login_session($user);
            return TRUE;
		}
        return FALSE;
	}


	/**
	 * [login_action 用户登录]
	 */
	public function login_action($pwd, $email, $phone, $rememberme)
	{
		$login_type = array();

		if( ! empty($phone) )
		{
			$login_type ['phone'] = $phone;
		}
		else if( ! empty($email) )
		{
			$login_type ['email'] = $email;
		}
		else
		{
            return FALSE;  
		}

		$user = $this->user_model->login_action($login_type, $pwd);
        if( ! empty($user))
        {
            if($rememberme) 
            {
                //设置 cookie
                $this->auth_service->set_remember_me_cookie($user);
            }
            //设置 SESSION
            $this->auth_service->set_login_session($user); 
            return $user;          
        }
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
        $this->auth_service->logout();
    }

    /**
     * [update_count 更新用户字段数量]
     * @param  [type] $uid    [用户id]
     * @param  [type] $name   [字段名称]
     * @param  [type] $amount [数量]
     * @return [type]         [description]
     */
    public function update_count($uid, $name, $amount)
    {
        return $this->user_model->update_count($uid,array('name' => $name, 'amount' => $amount));
    }


    /**
     * [get_user_by_id 获取用户信息]
     */
    public function get_user_by_id($uid,$custom = NULL)
    {
    	return $this->user_model->get_user_by_id($uid,$custom);
    }


    /**
     * [update_account 更新个人信息]
     */
    public function update_account($uid, $data)
    {
    	//清除值为空的变量
    	$this->_clear($data);
    	return $this->user_model->update_account($uid, $data);
    }


    /**
     * [change_password 更改密码]
     */
    public function change_password($uid, $old_pwd, $new_pwd)
    {
    	if(isset($old_pwd, $new_pwd)) 
    	{
    		return $this->user_model->change_password($uid, $old_pwd, $new_pwd);
    	}
    	return FALSE;
    }

    /**
     * [check_email 查看邮箱是否重复]
     * @param  [type] $email [邮箱]
     * @return [type]        [description]
     */
    public function check_email($email)
    {
    	return $this->user_model->have_email($email);
    }

    /**
     * [check_phone 查看手机是否重复]
     * @param  [type] $phone [手机]
     * @return [type]        [description]
     */
    public function check_phone($phone)
    {
    	return $this->user_model->have_phone($phone);
    }

    /**
     * [_clear 清除值为空的变量]
     * @param  [array] $data [description]
     * @return [type]       [description]
     */
    private function _clear($data)
    {
    	foreach ($data as $key => $value) 
    	{
    		if(is_string($data[$key])) 
    		{
    			//去除字符串两端的空格
    			$data[$key] = trim($data[$key]);
    		}
    		//unset 空的变量
    		if(empty($data[$key]))
    		{
    			unset($data[$key]);
    		}
    	}
    	return $data;
    }
}