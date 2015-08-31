<?php
class Main extends MY_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->service('artist_service');
	}

	public function index()
	{
		$head['css'] = array(
			'base.css',
			'font-awesome/css/font-awesome.min.css',
			'alert.css',
			'material-cards.css'
		);

		$head['javascript'] = array(
			'jquery.js',
			'error.js',
			'timeago.js',
			'alert.min.js',
			'autosize.js',
			'ajaxfileupload.js',
			'masonry.pkgd.min.js'
		);

		$user['user']= $this->user;
		$data['top'] = $this->load->view('common/top', $user, TRUE);
		$data['footer'] = $this->load->view('common/footer', '', TRUE);
		$head['title'] = '艺术家';
		$this->load->view('common/head', $head);
		$this->load->view('artist', $data);
	}	

	/**
	 * [get_artist_list 获取艺术家列表]
	 * @return [type] [description]
	 */
	public function get_artist_list()
	{
//		$page = $this->sc->input('page');
		$page = 0;
		$artist = $this->artist_service->get_artist_list($page);
		echo json_encode($artist);
	}
}