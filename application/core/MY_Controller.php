<?php

class MY_Controller extends CI_Controller{

    protected $user;

	public function __construct()
    {
		parent::__construct();

        $this->user = array();

        if( $this->user = $this->auth_service->non_login_in() )
        {
        }
        else
        {
        }

		$auth_result = $this->auth_service->check_user_auth();
		if( ! $auth_result)
		{
			exit('no_auth');
		}
	}
}