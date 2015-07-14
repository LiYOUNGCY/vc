<?php

class MY_Controller extends CI_Controller{

    protected $user;

	public function __construct()
    {
		parent::__construct();

		//用户权限检查
		$auth_result = $this->auth_service->check_user_auth();
		if( ! $auth_result)
		{
			exit('no_auth');
		}
        $this->user = array();

		// 
		if( $user['id'] = $this->auth_service->non_login_in() )
		{
			echo "<script>alert('login in')</script>";
		}
		else
		{
			echo "<script>alert('login no')</script>";
		}
	}
}