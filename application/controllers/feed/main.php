<?php

class Main extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->service('feed_service');
    }

    /**
     * [index 显示动态列表]
     * @return [type] [description]
     */
    public function index()
    {
		$page = $this->sc->input('page');
		$this->user = array();
		$this->user['id'] = 4;
		$feed = $this->feed_service->get_feed_list($page,$this->user['id']);
		if( ! empty($feed))
		{
			echo json_encode($feed);
		}
		else
		{
			echo "failed";
		}
    }
}