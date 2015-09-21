<?php
class Main extends MY_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->service('production_service');
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
            'alert.min.js',
            'masonry.pkgd.min.js',
            'jquery.imageloader.js'
        );

        $user['user']= $this->user;
        $data['top']            = $this->load->view('common/top', $user, TRUE);
        $data['footer']         = $this->load->view('common/footer', '', TRUE);
        $head['title'] = '艺术品';
        $this->load->view('common/head', $head);
        $this->load->view('production_list', $data);
	}

	/**
	 * 获得作品列表
	 * @return [type]
	 */
	public function get_production_list()
	{
//		$page = $this->sc->input('page');

        $page = 0;

        $medium = $this->sc->input('m', 'get');
        $categories = $this->sc->input('c', 'get');
        $style = $this->sc->input('s', 'get');
        $price = $this->sc->input('p', 'get');

        $search = array(
            'medium'        => $medium,
            'categories'    => $categories,
            'style'         => $style,
            'price'         => $price
        );

        $uid  = isset($this->user['id']) ? $this->user['id'] : NULL;
		$production = $this->production_service->get_production_list($page,$uid, $search);
		echo json_encode($production);
	}
}
