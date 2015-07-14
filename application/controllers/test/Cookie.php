<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Cookie extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('cookie');
	}

	public function start()
	{
		echo 'set cookie';
		$this->input->set_cookie();
	}

	public function check()
	{
		get_cookie('a');
	}

	public function test()
	{
		$this->load->library('generator');
		$this->generator->getGenerator(new SecurityLib\Strength(SecurityLib\Strength::MEDIUM));
		// $bytes = $generator->generate(32);	
	}
}