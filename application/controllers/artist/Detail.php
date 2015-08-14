<?php
class Detail extends MY_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->service('artist_service');
	}

	public function index($aid)
	{
		if( ! is_numeric($aid))
		{
			show_404();
		}
		$artist = $this->artist_service->get_artist_by_id($aid);
		if(empty($artist))
		{
			show_404();
		}
		echo json_encode($artist);
	}
	
	
}