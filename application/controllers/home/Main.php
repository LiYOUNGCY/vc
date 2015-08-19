<?php


class Main extends MY_Controller {
    public function __construct()
    {
        parent::__construct();

        $this->load->service('home_service');
    }


    /**
     * [index 显示首页]
     * @return [type]       [description]
     */
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
            'jquery.imageloader.js'
        );

        $all = $this->home_service->enter_index();

        $user['user'] = $this->user;
        $top = $this->load->view('common/top', $user, TRUE);
        $data['title']        = "最专业的艺术导购";
        $body['top']          = $top;
        $body['user']         = $this->user;

        $this->load->view('common/head', $data);
        $this->load->view('home', $body);
    }
}
