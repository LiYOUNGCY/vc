<?php

class Main extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->service('feed_service');
    }

    /**
     * [index 显示动态界面]
     * @return [type] [description]
     */
    public function index()
    {

    	$this->load->view("feed");
    }

    /**
     * [get_feed_list 获取动态列表]
     * @return [type] [description]
     */
    public function get_feed_list()
    {
		$page = $this->sc->input('page');
		$feed = $this->feed_service->get_feed_list($page,$this->user['id']);
		echo json_encode($feed);
    }
}