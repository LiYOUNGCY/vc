<?php defined('BASEPATH') OR exit('No direct script access allowed');


class User_service extends MY_Service
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
		$this->load->service('auth_service');
	}


	public function register_action($name, $pwd, $email, $phone)
	{
		$register_type = array();
		if( isset ($phone) )
		{
			$register_type['phone'] = $phone;
		}
		else if( isset ($email) )
		{
			$register_type['email'] = $email;
		}
		else 
		{
			//错误
			return FALSE;
		}
		return $this->user_model->register_action ($name, $register_type, $pwd);
	}

	public function login_action($pwd, $email, $phone)
	{
		$login_type = array();

		if( isset($phone) )
		{
			$login_type ['phone'] = $phone;
		}
		else if( isset($email) )
		{
			$login_type ['email'] = $email;
		}
		else
		{
			//错误
		}

		$user = $this->user_model->login_action($login_type, $pwd);

		if( isset( $user ) )
		{
			//设置 cookie
			$this->auth_service->set_remember_me_cookie($user);
			//设置 SESSION
			$this->auth_service->set_login_session($user);

			return true;
		}
		else 
		{
			return false;
		}
	}

    /**
     * [update_count 更新用户字段数量]
     * @param  [type] $uid    [用户id]
     * @param  [type] $name   [字段名称]
     * @param  [type] $amount [数量]
     * @return [type]         [description]
     */
    public function update_count($uid,$name,$amount)
    {
        return $this->user_model->update_count($uid,array('name' => $name, 'amount' => $amount));
    }

    /**
     * [get_user_by_id 获取用户信息]
     * @param  [type] $uid [用户id]
     * @return [type]      [description]
     */
    public function get_user_by_id($uid,$custom = NULL)
    {
    	return $this->user_model->get_user_by_id($uid,$custom);
    }	
}