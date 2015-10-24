<?php

class main extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->service('user_service');
    }

    public function index($type)
    {
        $data['css'] = array(
            'swiper.min.css',
            'font-awesome/css/font-awesome.min.css',
            'base.css',

        );
        $data['javascript'] = array(
            'jquery.js',
            'masonry.pkgd.min.js',
            'jquery.imageloader.js',
            'error.js',
        );

        $user['user'] = $this->user;
        $user['sign'] = $this->load->view('common/sign', '', true);
        $body['top'] = $this->load->view('common/top', $user, true);
        $body['footer'] = $this->load->view('common/footer', '', true);
        $body['user'] = $this->user;

        if ($type == 'terms') {
            $data['title'] = '用户协议';
            $this->load->view('common/head', $data);
            $this->load->view('terms', $body);
        } elseif ($type == 'us') {
            $data['title'] = '关于我们';
            $this->load->view('common/head', $data);
            $this->load->view('us', $body);
        } elseif ($type == 'service') {
            $data['title'] = '服务保证';
            $this->load->view('common/head', $data);
            $this->load->view('service', $body);
        } elseif ($type == 'dealrole') {
            $data['title'] = '交易须知';
            $this->load->view('common/head', $data);
            $this->load->view('dealrole', $body);
        } elseif ($type == 'aftersale') {
            $data['title'] = '售后服务';
            $this->load->view('common/head', $data);
            $this->load->view('aftersale', $body);
        }
    }
}
