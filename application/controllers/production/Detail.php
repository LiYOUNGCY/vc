<?php
class Detail extends MY_Controller{

	public function __construct()
	{
		parent::__construct();
		$this->load->service('production_service');
	}

	public function index($pid)
	{
		if( ! is_numeric($pid))
		{
			show_404();
		}
		$production = $this->production_service->get_production_by_id($pid);
		if(empty($production))
		{
			show_404();
		}

		$uid = isset($this->user['id']) ? $this->user['id'] : NULL;

		$production['pic_thumb'] 		= Common::get_thumb_url($production['pic'],'thumb2_');

        $data['production'] 	= $production;
        //获取相关联的专题
        //$data['topic'] 			= $this->production_service->get_topic_by_production($pid,$uid);

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
            'zoomtoo.js',
            'zoom.js'
        );


        $user['user'] = $this->user;
        $data['title']        = $production['name'];
        $body['top']          = $this->load->view('common/top', $user, TRUE);
        $body['sign']         = $this->load->view('common/sign', '', TRUE);
        $body['footer']       = $this->load->view('common/footer', '', TRUE);
        $body['user']         = $this->user;

        $this->load->view('common/head', $data);
        $this->load->view('production_detail', $body);


	}

	/**
	 * [like_production 点赞作品]
	 * @return [type] [description]
	 */
	public function like_production()
	{
		$pid = $this->sc->input('pid');
		$this->production_service->like_production($pid,$this->user['id']);
	}
}
