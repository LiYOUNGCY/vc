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
			$this->auth_service->set_remember_me_cookie($user['id']);
			//设置 SESSION
			$this->auth_service->set_login_session($user['id']);

			return true;
		}
		else 
		{
			return false;
		}
	}
}