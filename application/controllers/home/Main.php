<?php


class Main extends MY_Controller {
    public function __construct()
    {
        parent::__construct();
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

        $user['user'] = $this->user;
        $sidebar = $this->load->view('common/sidebar', $user, TRUE);

        $body['sidebar']      = $sidebar;
        $body['user']         = $this->user;

        $this->load->view('common/head', $data);
        $this->load->view('home', $body);
    }
}
