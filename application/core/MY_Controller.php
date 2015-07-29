<?php

class MY_Controller extends CI_Controller{

    protected $user;
    protected $default_lang;

	public function __construct()
    {
		parent::__construct();

        $this->user = array();
        $this->default_lang = 'zh-CN';
        $user = $this->auth_service->non_login_in();

        //登陆了
        if( $user != FALSE )
        {
            $this->user = $user;
        }
        //没登陆
        else
        {
            $user['name'] = '请登录';
            $user['pic']  = base_url().'public/img/icon/question_icon.png';
            $user['alias']= base_url().'login';
            $user['role'] = 0;
            $this->user = $user;
        }

		$auth_result = $this->auth_service->check_user_auth();
		if( ! $auth_result)
		{
			exit('no_auth');
		}

        //加载语言
        $this->lang->load('error', $this->default_lang);
        $this->lang->load('base', $this->default_lang);        
	}
}