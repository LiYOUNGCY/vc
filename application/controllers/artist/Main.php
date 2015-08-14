<?php
class Main extends MY_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->service('artist_service');
	}

	public function index()
	{

	}	

	/**
	 * [get_artist_list 获取艺术家列表]
	 * @return [type] [description]
	 */
	public function get_artist_list()
	{
		$page = $this->sc->input('page');
		$artist = $this->artist_service->get_artist_list($page);
		echo json_encode($artist);
	}
}