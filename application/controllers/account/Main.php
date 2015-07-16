<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Main extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();	
		$this->load->service('user_service');
	}

	public function login()
	{
		$phone = $this->sc->input('phone');
		$email = $this->sc->input('email');

		$pwd   = $this->sc->input('pwd');

		if ( $this->user_service->login_action($pwd, $email, $phone) == TRUE )
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

		$data = $this->user_service->register_action($name, $pwd, $email, $phone);
		var_dump($data);
	}
}