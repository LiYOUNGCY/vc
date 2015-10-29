<?php

/**
 * 创建订单的页面.
 */
class Main extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->service('user_service');
    }

    /**
     * [index description].
     *
     * @return [type] [description]
     */
    public function index()
    {
        //收货地址
        $address = $this->user_service->get_address($this->user['id']);
        //配送方式

        //作品列表

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
        $data['title'] = '支付';
        $body['top'] = $this->load->view('common/top', $user, true);
        $body['footer'] = $this->load->view('common/footer', '', true);
        $body['user'] = $this->user;

        $this->load->view('common/head', $data);
        $this->load->view('pay', $body);
    }
}
