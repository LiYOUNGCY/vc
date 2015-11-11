<?php

class Email extends MY_Controller
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
            'error.js',
        );

        $user['user'] = $this->user;
        $user['sign'] = $this->load->view('common/sign', '', true);
        $body['top'] = $this->load->view('common/top', $user, true);
        $body['footer'] = $this->load->view('common/footer', '', true);
        $body['user'] = $this->user;

        if ($type == 'sended') {
            $data['title'] = '已发送邮件';
            $this->load->view('common/head', $data);
            $this->load->view('email_sended', $body);
        } elseif ($type == 'success') {
            $data['title'] = '验证成功';
            $this->load->view('common/head', $data);
            $this->load->view('email_success', $body);
        }
    }

    public function active()
    {
        $token = $this->sc->input('token', 'get');

        $result = $this->user_service->active_email($token);

        if ($result) {
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
            $data['title'] = '验证成功';
            $this->load->view('common/head', $data);
            $this->load->view('email_success', $body);
        }
    }
}
