<?php

class Main extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->service('cart_service');
    }

    public function index()
    {
        $head['css'] = array(
            'base.css',
            'font-awesome/css/font-awesome.min.css',
            'alert.css',
        );

        $head['javascript'] = array(
            'jquery.js',
            'error.js',
            'alert.min.js',
        );

        $user['user'] = $this->user;
        $user['sign'] = $this->load->view('common/sign', '', true);

        $head['title'] = '购物车';
        $body['top'] = $this->load->view('common/top', $user, true);
        $body['footer'] = $this->load->view('common/footer', '', true);
        $body['user'] = $this->user;

        $this->load->view('common/head', $head);
        $this->load->view('cart', $body);
    }

    /**
     * [get_good_list 获取购物车物品列表].
     *
     * @return [type] [description]
     */
    public function get_good_list()
    {
        $goods = $this->cart_service->get_good_list($this->user['id']);
        echo json_encode($goods);
    }

    /**
     * [remove_good 移除购物车物品].
     *
     * @return [type] [description]
     */
    public function remove_goods()
    {
        $production_id = $this->sc->input('id');

        $this->cart_service->remove_goods($this->user['id'], $production_id);

        $this->message->success();
    }

    /**
     * [get_cart_count 获取购物车上的商品数].
     *
     * @return [type] [description]
     */
    public function get_cart_count()
    {
        $query = $this->cart_service->get_cart_count_by_user($this->user['id']);
        $this->message->success($query);
    }

    /**
     * [add_goods 添加艺术品到购物车].
     */
    public function add_goods()
    {
        $production_id = $this->sc->input('production_id');
        $frame_id = $this->sc->input('frame_id');

        $this->cart_service->insert_goods_to_cart($this->user['id'], $production_id, $frame_id);

        $this->message->success();
    }

    /**
     * [check_goods 检查商品是否售罄]
     * @return [type] [description]
     */
    public function check_goods()
    {
        $query = $this->cart_service->check_goods_sell_out($this->user['id']);

        if( $query === true) {
            $this->message->success();
        }

        $message = '';
        foreach($query as $value) {
            $message = $message . $value['name'] . $value['status'];
        }

        $this->message->error($message);
    }
}
