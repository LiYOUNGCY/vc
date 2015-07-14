<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Register extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->service('user_service');
	}

	public function index()
	{
		$name = $this->sc->input('name');
		$pwd = $this->sc->input('pwd');

		$email = $this->sc->input('email');
		$phone = $this->sc->input('phone');

		$this->user_service->register_action($name, $pwd, $email, $phone);
	}
}