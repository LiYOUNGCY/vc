<?php
class Main extends MY_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->service('transaction_service');
	}

	public function index()
	{
		$data['css'] = array(
            'swiper.min.css',
            'font-awesome/css/font-awesome.min.css',
            'base.css'
        );
        $data['javascript'] = array(
            'jquery.js',
            'masonry.pkgd.min.js',
            'jquery.imageloader.js',
            'error.js',
            'validate.js'
        );

        $user['user'] = $this->user;
        $user['sign'] = $this->load->view('common/sign', '', TRUE);

        $data['title']        = "购买记录 - 用户中心";
        $body['top']          = $this->load->view('common/top', $user, TRUE);
        $body['footer']       = $this->load->view('common/footer', '', TRUE);
        $body['user']         = $this->user;

        $this->load->view('common/head', $data);
        $this->load->view('transaction', $body);
	}

	public function get_transaction_list()
	{
		$page = $this->sc->input('page');
		//$page = 0;
		$transaction = $this->transaction_service->get_transaction_list($page, $this->user['id']);
		echo json_encode($transaction);
	}

}