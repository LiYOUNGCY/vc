<?php

class Main extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->service('user_service');
    }

    public function index($type)
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
            'error.js'
        );

        $user['user']         = $this->user;
        $user['sign']         = $this->load->view('common/sign', '', TRUE);
        $body['top']          = $this->load->view('common/top', $user, TRUE);
        $body['footer']       = $this->load->view('common/footer', '', TRUE);
        $body['user']         = $this->user;

        
        if($type == "terms"){
            $data['title']        = "用户协议";
            $this->load->view('common/head', $data);
            $this->load->view('terms', $body);
        }

    }
}
