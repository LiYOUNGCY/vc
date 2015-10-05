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
        }else if($type == "us"){
            $data['title']        = "关于我们";
            $this->load->view('common/head', $data);
            $this->load->view('us', $body);
        }else if($type == "service"){
            $data['title']        = "服务保证";
            $this->load->view('common/head', $data);
            $this->load->view('service', $body);
        }else if($type == "dealrole"){
            $data['title']        = "交易须知";
            $this->load->view('common/head', $data);
            $this->load->view('dealrole', $body);
        }else if($type == "aftersale"){
            $data['title']        = "售后服务";
            $this->load->view('common/head', $data);
            $this->load->view('aftersale', $body);
        }
    }
}
