<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Login extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->service('user_service');
	}

	public function index()
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
}