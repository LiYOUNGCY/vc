<?php
class Main extends MY_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->service('like_service');
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
        $top = $this->load->view('common/top', $user, TRUE);
        $data['title']        = "我的喜欢 - 用户中心";
        $body['top']          = $top;
        $body['sign']         = $this->load->view('common/sign', '', TRUE);
        $body['footer']       = $this->load->view('common/footer', '', TRUE);
        $body['user']         = $this->user;

        $this->load->view('common/head', $data);
        $this->load->view('like_list', $body);
	}	

	/**
	 * [get_article_like_list 获取文章收藏列表]
	 * @return [type] [description]
	 */
	public function get_article_like_list()
	{	
		$page = $this->sc->input('page');
		$like = $this->like_service->get_article_like_list($page,$this->user['id']);
		echo json_encode($like);
	}

	/**
	 * [get_production_like_list 获取作品收藏列表]
	 * @return [type] [description]
	 */
	public function get_production_like_list()
	{	
		$page = $this->sc->input('page');
		$like = $this->like_service->get_production_like_list($page,$this->user['id']);
		echo json_encode($like);		
	}	
}