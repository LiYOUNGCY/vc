<?php

class MY_Controller extends CI_Controller{

    protected $user;
    protected $default_lang;

	public function __construct()
    {
		parent::__construct();

        $this->user = array();
        $this->default_lang = 'zh-CN';

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

        //加载语言
        $this->lang->load('error', $this->default_lang);
	}
}