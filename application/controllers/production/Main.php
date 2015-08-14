<?php
class Main extends MY_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->service('production_service');
	}

	public function index()
	{

	}

	/**
	 * 获得作品列表
	 * @return [type]
	 */
	public function get_production_list()
	{
		$page = $this->sc->input('page');
        $uid  = isset($this->user['id']) ? $this->user['id'] : NULL;
		$production = $this->production_service->get_production_list($page,$uid);
		echo json_encode($production);
	}
	
}