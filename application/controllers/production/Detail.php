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
		if( ! empty($uid))
		{
            //获取收藏状态
            $collect_status = $this->production_service->check_production_collection($uid, $pid);
            $collect_status = !empty($collect_status) ? $collect_status['status'] : 0;          
		}
		else
		{
			$collect_status = 0;
		}
		$production['pic_thumb'] 		= Common::get_thumb_url($production['pic'],'thumb2_');

        $data['production'] 	= $production;
        $data['collect_status'] = $collect_status;
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
	 * 收藏艺术品
	 * @return [type]
	 */
	public function collect_production()
	{
        $pid = $this->sc->input('pid');
        $uid = $this->user['id'];
        $this->production_service->collect_production($pid, $uid);		
	}


}