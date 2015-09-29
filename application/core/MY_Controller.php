<?php

class MY_Controller extends CI_Controller{

    protected $user;
    protected $default_lang;

	public function __construct()
    {
		parent::__construct();

        $this->user = array();
        $this->default_lang = 'zh-CN';
        //加载语言
        $this->lang->load('error', $this->default_lang);
        $this->lang->load('base', $this->default_lang);

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
            $user['alias']= 'login';
            $user['role'] = 0;
            $this->user = $user;
        }

		$auth = $this->auth_service->check_user_auth();

        //没有权限或没有登录的用户
        if(! $auth) {
            header(redirect(base_url() . 'home?callback=login'));
        }
	}
}
