<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Main extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();	
		$this->load->service('user_service');
	}


	public function index($type = 'login')
	{	
		if($type == 'login')
		{
			$this->load->view('login');			
		}
		else if($type == 'signup')
		{
			$this->load->view('register');			
		}
	}
		
	/**
	 * [login 登陆]
	 */
	public function login()
	{
		$phone 		= $this->sc->input('phone');
		$email 		= $this->sc->input('email');
		$pwd   		= $this->sc->input('pwd');
		$rememberme = $this->sc->input('rememberme');

		$result = $this->user_service->login_action($pwd, $email, $phone, $rememberme);
		if($result)
		{
			//登陆成功, 重定向首页 ?
			redirect();			
		}
		else
		{
			$this->error->output('LOGIN_ERROR');			
		}

	}


	/**
	 * [register 注册]
	 */
	public function register()
	{
		$name 	= $this->sc->input('name');
		$pwd 	= $this->sc->input('pwd');
		$email 	= $this->sc->input('email');
		$phone 	= $this->sc->input('phone');

		$this->user_service->register_action($name, $pwd, $email, $phone);

		//注册成功, 重定向首页 ?
		redirect();
	}

	/**
	 * [check_phone 查看手机是否重复]
	 * @return [type] [description]
	 */
	public function check_phone()
	{
		$phone  = $this->sc->input('phone');
		$result = $this->user_service->check_phone($phone);
		if($result)
		{
			echo json_encode(array('success' => 0));
		}
		else
		{
			$this->error->output('PHONE_REPEAT');
		}

	}

	/**
	 * [check_email 查看邮箱是否重复]
	 * @return [type] [description]
	 */
	public function check_email()
	{
		$email  = $this->sc->input('email');
		$result = $this->user_service->check_email($email);		
		if($result)
		{
			echo json_encode(array('success' => 0));
		}
		else
		{
			$this->error->output('EMAIL_REPEAT');
		}
	}
}