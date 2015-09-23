<?php

class Main extends MY_Controller
{
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
            'material-cards.css',
            'easydropdown.css'
        );

        $head['javascript'] = array(
            'jquery.js',
            'alert.min.js',
            'masonry.pkgd.min.js',
            'jquery.imageloader.js',
            'jquery.easydropdown.js'
        );

        $user['user'] = $this->user;
        $data['top'] = $this->load->view('common/top', $user, TRUE);
        $data['footer'] = $this->load->view('common/footer', '', TRUE);
        $data['medium'] = $this->production_service->get_medium_list();
        $data['style']  = $this->production_service->get_style_list();
        $data['price']  = $this->production_service->get_price_list();
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
		$page = $this->sc->input('page');

//        $page = 0;

        $medium = $this->sc->input('m', 'get');
        $categories = NULL;
        $style = $this->sc->input('s', 'get');
        $price = $this->sc->input('p', 'get');

        $medium = strcmp($medium, '0') === 0  ? NULL : $medium;
        $style = strcmp($style, '0') === 0 ? NULL : $style;
        $price = strcmp($price, '0') === 0 ? NULL : $price;


        $search = array(
            'medium' => $medium,
            'categories' => $categories,
            'style' => $style,
            'price' => $price
        );

        $uid = isset($this->user['id']) ? $this->user['id'] : NULL;
        $production = $this->production_service->get_production_list($page, $uid, $search);
        echo json_encode($production);
    }
}
