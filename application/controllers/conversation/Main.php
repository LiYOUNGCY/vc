<?php
class Main extends MY_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->service('conversation_service');
	}


	public function index()
	{
		$head['css'] = array(
			'base.css',
            'alert.css',
            'qqFace.css'
		);
		$head['javascript'] = array(
			'jquery.js',
            'alert.min.js',
            'autosize.js',
            'jquery.qqFace.js'
		);
        $head['title']   = '在线客服';

        $user['user'] = $this->user;
        $user['sign'] = $this->load->view('common/sign', '', TRUE);

        $body['top']     = $this->load->view('common/top', $user, TRUE);
        $body['footer']  = $this->load->view('common/footer', '', TRUE);
//		$body['customer_id'] = $this->conversation_service->get_customer_id();

		$this->load->view('common/head', $head);
		$this->load->view('customer', $body);
	}


    /**
     * 获取所有客服的 id
     * @return [type] [description]
     */
    public function get_customer_id()
    {
        $ids = $this->conversation_service->get_customer_id();
        echo json_encode($ids);
    }
}
