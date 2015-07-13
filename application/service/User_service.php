<?php defined('BASEPATH') OR exit('No direct script access allowed');


class User_service extends MY_Service
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
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
		}
		$this->user_model->register_user($name, $register_type, $pwd);
	}

	public function login_action($login_type, $pwd)
	{
		
	}
}