<?php
class Main extends MY_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->service('like_service');
	}

	public function index($type = "article")
	{
		$data['css'] = array(
            'swiper.min.css',
            'font-awesome/css/font-awesome.min.css',
            'base.css',
            'alert.css'
        );
        $data['javascript'] = array(
            'jquery.js',
            'masonry.pkgd.min.js',
            'jquery.imageloader.js',
            'error.js',

            'alert.min.js'
        );

        $user['user'] = $this->user;
        $user['sign'] = $this->load->view('common/sign', '', TRUE);

        $data['title']        = "我的喜欢 - 用户中心";
        $body['top']          = $this->load->view('common/top', $user, TRUE);
        $body['footer']       = $this->load->view('common/footer', '', TRUE);
        $body['user']         = $this->user;

        $this->load->view('common/head', $data);
        if($type == "article"){
        	$this->load->view('like_list_article', $body);
        }else if($type == "production"){
        	$this->load->view('like_list_production', $body);
        }

	}

	/**
	 * [get_article_like_list 获取文章收藏列表]
	 * @return [type] [description]
	 */
	public function get_article_like_list()
	{
		$page = $this->sc->input('page');
		//$page = 0;
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
		//$page = 0;
		$like = $this->like_service->get_production_like_list($page,$this->user['id']);
		echo json_encode($like);
	}
}
