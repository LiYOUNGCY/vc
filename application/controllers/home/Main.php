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
            'base.css',
            'font-awesome/css/font-awesome.min.css'
        );
        $data['javascript'] = array(
            'jquery.js',
            'masonry.pkgd.min.js',
            'jquery.imageloader.js',
            'jquery.scrollLoading.js'
        );

        $user['user'] = $this->user;
        $sidebar = $this->load->view('common/sidebar', $user, TRUE);

        $body['sidebar']      = $sidebar;
        $body['user']         = $this->user;

        $this->load->view('common/head', $data);
        $this->load->view('home', $body);
    }
}
