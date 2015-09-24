<?php
class Login extends MY_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->service('user_service');
	}

	/**
	 * [index 登陆界面]
	 * @return [type] [description]
	 */
	public function index()
	{
		//已登录直接跳入面板
		if(isset($this->user['id']))
		{
			if($this->user['role'] == 99)
				redirect(base_url().ADMINROUTE.'main','location');	
		}		
		$foot = $this->load->view('admin/common/foot',"",TRUE);				
		$body['foot']	= $foot;
		$this->load->view('admin/common/head');		
		$this->load->view('admin/login',$body);

	}

	/**
	 * [login_action 登录(与前台共用同个服务,只支持邮箱登录)]
	 * @return [type] [description]
	 */
	public function login_action()
	{
		$error_redirect = array(
			'script' => 'window.location.href = "'.base_url().'";'
		);
		$this->sc->set_error_redirect($error_redirect);

		$email = $this->sc->input('email');
		$pwd   = $this->sc->input('pwd');
		$rememberme = $this->sc->input('rememberme');
		$user  = $this->user_service->login_action($pwd,$email,NULL,$rememberme);
		if($user)
		{
			if($user['role'] == 99){
				//成功,重定向至管理员面板
				redirect(base_url().ADMINROUTE.'main','location');			
			}
			else
			{
				//失败,重定向至首页
				redirect(base_url(),'location');
			}			
		}
		else
		{

			$this->error->output('LOGIN_ERROR',array(
					'script' => 'window.location.href = "'.base_url().'";'
			));
		}
	}


}