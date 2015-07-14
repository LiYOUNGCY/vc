<?php
class MY_Controller extends CI_Controller
{
    protected $user;


	public function __construct()
    {
		parent::__construct();
		$this->load->service('auth_service');
        $this->user = array();

		// 记住密码功能
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