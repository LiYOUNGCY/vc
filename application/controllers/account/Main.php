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

	public function login()
	{
		$phone = $this->sc->input('phone');
		$email = $this->sc->input('email');

		$pwd   = $this->sc->input('pwd');
		$rememberme = $this->sc->input('rememberme');

		if ( $this->user_service->login_action($pwd, $email, $phone, $rememberme) == TRUE )
		{
			echo 'login in success';
		}
		else 
		{
			echo 'login in fail';
		}
	}

	public function register()
	{
		$name = $this->sc->input('name');
		$pwd = $this->sc->input('pwd');

		$email = $this->sc->input('email');
		$phone = $this->sc->input('phone');
		var_dump($email);

		$data = $this->user_service->register_action($name, $pwd, $email, $phone);
		var_dump($data);
	}
}