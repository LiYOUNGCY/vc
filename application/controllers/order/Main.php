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
        $this->load->service('cart_service');
        $this->load->service('order_service');
        $this->load->service('production_service');
    }

    /**
     * [index description].
     *
     * @return [type] [description]
     */
    public function index()
    {
        $data['css'] = array(
            'swiper.min.css',
            'font-awesome/css/font-awesome.min.css',
            'base.css',
            'radiocheck.min.css',
        );
        $data['javascript'] = array(
            'jquery.js',
            'geo.js',
            'error.js',
        );

        $user['user'] = $this->user;
        $user['sign'] = $this->load->view('common/sign', '', true);
        $data['title'] = '支付';

        //收货地址
        $address = $this->user_service->get_address($this->user['id']);

        //配送方式
        $transport = $this->order_service->get_transport_by_address($address['address']);
        $body['top'] = $this->load->view('common/top', $user, true);
        $body['footer'] = $this->load->view('common/footer', '', true);
        $body['user'] = $this->user;
        $body['transport'] = $transport;
        $body['address'] = $address;

        $type = $this->sc->input('t', 'get');
        //从购物车跳转
        if($type == 'cty') {
            //作品列表
            $goods = $this->cart_service->get_good_list($this->user['id']);
            $body['goods'] = $goods;
            $body['post_url'] = base_url() .'pay/main/pay_for_cart';

            $this->load->view('common/head', $data);
            $this->load->view('pay', $body);
        }
        else if($type == 'pis') {
            $production_id = $this->sc->input('pid');
            $frame_id = $this->sc->input('fid');


            //作品列表
            $goods = $this->production_service->get_production_with_frame($production_id, $frame_id);
            $body['goods'] = $goods;
            $body['post_url'] = base_url() .'pay/main/pay_for_cart';

            $this->load->view('common/head', $data);
            $this->load->view('pay', $body);

            // echo json_encode($goods);
        }
        else {
            show_404();
        }
    }
}
