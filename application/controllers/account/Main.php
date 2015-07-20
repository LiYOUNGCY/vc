<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Main extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();	
		$this->load->service('user_service');
	}


	public function index()
	{	
		$this->load->view('login');
	}
	

	public function signup()
	{
		$this->load->view('register');
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

		$this->user_service->login_action($pwd, $email, $phone, $rememberme);

		//登陆成功, 重定向首页 ?
		redirect();
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
}