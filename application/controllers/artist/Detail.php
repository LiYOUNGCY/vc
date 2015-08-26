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
		//echo json_encode($artist);
		
        $data['css'] = array(
            'font-awesome/css/font-awesome.min.css',
            'base.css'
        );
        $data['javascript'] = array(
            'jquery.js',
            'masonry.pkgd.min.js',
            'jquery.imageloader.js',
            'error.js',
            'validate.js',
            'masonry.pkgd.min.js'
        );


        $user['user'] 		  = $this->user;
        $data['title']        = $artist['name'];
        $body['top']          = $this->load->view('common/top', $user, TRUE);
        $body['sign']         = $this->load->view('common/sign', '', TRUE);
        $body['footer']       = $this->load->view('common/footer', '', TRUE);
        $body['user']         = $this->user;
        $body['artist']		  = $artist;

        $this->load->view('common/head', $data);
        $this->load->view('artist_detail', $body);
	}

	/**
	 * [get_artist_production 获取艺术家作品列表]
	 * @return [type] [description]
	 */
	public function get_artist_production()
	{
		$page = $this->sc->input('page');
		$aid  = $this->sc->input('aid');
		$production = $this->artist_service->get_artist_production($page,$aid);
		echo json_encode($production);
	}
}