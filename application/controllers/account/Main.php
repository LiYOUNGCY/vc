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
		$user['user'] = $this->user;
		$sidebar = $this->load->view('common/sidebar', $user, TRUE);

        $body['sidebar'] = $sidebar;
		if($type == 'login')
		{
			$this->load->view('login', $body);			
		}
		else if($type == 'signup')
		{
			$this->load->view('register', $body);			
		}
	}


	/**
	 * [login_by_email 邮箱登陆]
	 */
	public function login_by_email()
	{
		$email 		= $this->sc->input('email');
		$pwd   		= $this->sc->input('pwd');
		$rememberme = $this->sc->input('rememberme');


		$result = $this->user_service->login_action($pwd, $email, NULL, $rememberme);
		if($result)
		{
			//登陆成功, 重定向首页 ?
			//redirect()
			echo 'success';		
		}
		else
		{
			$this->error->output('LOGIN_ERROR');			
		}

	}


	/**
	 * [login_by_phone 手机号码登陆]
	 */
	public function login_by_phone()
	{
		$phone 		= $this->sc->input('phone');
		$pwd   		= $this->sc->input('pwd');
		$rememberme = $this->sc->input('rememberme');


		$result = $this->user_service->login_action($pwd, NULL, $phone, $rememberme);
		if($result)
		{
			//登陆成功, 重定向首页 ?
			//redirect()
			echo 'success';		
		}
		else
		{
			$this->error->output('LOGIN_ERROR');			
		}
	}


	/**
	 * [register 邮箱注册]
	 */
	public function register_by_email()
	{
		$name 	= $this->sc->input('name');
		$email 	= $this->sc->input('email');
		$pwd 	= $this->sc->input('pwd');


		$this->user_service->register_action($name, $pwd, $email, NULL);

		//注册成功, 重定向首页 ?
		//redirect();
	}


	/**
	 * [register_by_phone 手机号码注册]
	 */
	public function register_by_phone()
	{
		$name 	= $this->sc->input('name');
		$phone 	= $this->sc->input('phone');
		$pwd 	= $this->sc->input('pwd');

		$this->user_service->register_action($name, $pwd, NULL, $phone);
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