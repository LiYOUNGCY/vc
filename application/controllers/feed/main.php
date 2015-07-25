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
        $data['css'] = array('common.css', 'font-awesome/css/font-awesome.min.css');
        $data['javascript'] = array('jquery.js');

        $this->load->view('common/head', $data);
        $sidebar = $this->load->view('common/sidebar', '', TRUE);

        $body['sidebar'] = $sidebar;

    	$this->load->view("feed",$body);

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