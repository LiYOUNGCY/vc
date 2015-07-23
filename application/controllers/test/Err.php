<?php 

class Err extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		// $this->load->library('error');
		$this->error->output('invalid_phone');
		// var_dump( lang("error_INVALID_PHONE") );
	}
}