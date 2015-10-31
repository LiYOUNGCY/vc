<?php

class Order extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('order_model');
    }

    /**
     * 所有订单
     *
     */
    public function index()
    {
        //获取艺术品列表
        $order = $this->order_model->get_order_list();

        $user['user'] = $this->user;
        $navbar = $this->load->view('admin/common/navbar', $user, true);


        $foot = $this->load->view('admin/common/foot', '', true);

        //页面数据
        $body = array(
            'navbar' => $navbar,
            'foot' => $foot,
            'order' => $order,
        );
        $this->load->view('admin/common/head');
        $this->load->view('admin/order/order_list', $body);
    }

    public function detail($order_id = '')
    {
//        if(! is_numeric($order_id)) {
//            show_404();
//        }

        //获取艺术品列表
        $order = $this->order_model->get_order_by_id($order_id);
        $orderitem = $this->order_model->get_orderitem_by_order_id($order_id);
        $user['user'] = $this->user;
        $navbar = $this->load->view('admin/common/navbar', $user, true);


        $foot = $this->load->view('admin/common/foot', '', true);

        //页面数据
        $body = array(
            'navbar' => $navbar,
            'foot' => $foot,
            'data' => $order,
            'goods' => $orderitem
        );
        $head['css'] = array('goods.css');
        $this->load->view('admin/common/head', $head);
        $this->load->view('admin/order/order_detail', $body);
    }

    public function send_goods()
    {
        $id = $this->sc->input('order_id');

        $result = $this->order_model->change_state($id, 3);

        if($result) {
            $this->message->success();
        }

        $this->message->error();
    }
}