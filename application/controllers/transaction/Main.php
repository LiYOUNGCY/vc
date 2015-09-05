<?php
class Main extends MY_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->service('transaction_service');
	}

	public function index()
	{

	}

	public function get_transaction_list()
	{
		$page = $this->sc->input('page');
		$transaction = $this->transaction_service->get_transaction_list($page, $this->user['id']);
		echo json_encode($transaction);
	}

}