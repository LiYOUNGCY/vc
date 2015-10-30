<?php

class Order_service extends MY_Service
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('order_model');
        $this->load->model('cart_model');
        $this->load->model('transport_model');
    }

    public function buy_in_cart($user_id, $contact_id, $transport_id, $issue_header)
    {
        //创建新订单
        $order_id = $this->order_model->create_order($user_id, $contact_id, $transport_id, $issue_header);

        //从用户的购物车取出全部艺术品添加到订单并计算总价
        $this->order_model->update_orderItem_by_cart($user_id, $order_id);

        //获得订单的简要信息
        $order = $this->order_model->get_order_message($user_id, $order_id);
        return $order;
    }

    public function validate_pay($user_id, $transport_id)
    {
        //检查购物车是否为空
        $count = (int)$this->cart_model->get_cart_count_by_user($user_id)['count'];

        if ($count <= 0) {
            //购物车为空
            $this->message->error('购物车没有商品' . "{$count}");
        }

        //检查艺术品售罄
        if ($this->cart_model->check_goods_sell_out($user_id)) {
            $this->message->error('您的购物车中的艺术品已被购买，详情请到购物车查看');
        }

        //检查变量的合法性
        $address = $this->user_model->get_address($user_id);

        //找不到地址 或 地址中某个值为空
        if (empty($address) || !$this->_check_empty_var($address)) {
            //提交错误, 收货信息不全
            $this->message->error('收货信息不能为空');
        }

        $transport = $this->transport_model->get_transport_by_id($transport_id);

        if (empty($transport)) {
            //没有这配送方式
            $this->message->error('请选择配送方式');
        }

        //检查配送方式是否符合地址
        if (!$this->_check_address($address['address'], $transport)) {
            //错误！！！送往该地址不用这种配送方式
            $this->message->error('系统错误');
        }
    }

    /**
     * 根据地址返回配送方式
     * @param $address
     */
    public function get_transport_by_address($address)
    {
        if ($this->_check_address_in_GuangZhuo($address)) {
            return $this->transport_model->get_transport_list_by_range(IN_GUANGZHUO);
        }

        return $this->transport_model->get_transport_list_by_range(NOT_IN_GUANGZHUO);
    }

    /**
     * 检查地址是否合法
     * @param $address
     * @param $transport
     * @return bool
     */
    private function _check_address($address, $transport)
    {
        //广州市内
        if ($transport['range'] == 1) {
            //该配送方式是送往广州,但是地址不在广州，所以不合法
            if (!$this->_check_address_in_GuangZhuo($address)) {
                return false;
            }
        } //广州市外
        else if ($transport['range'] == 2) {
            if ($this->_check_address_in_GuangZhuo($address)) {
                return false;
            }
        }
        return true;
    }

    /**
     * 检查该地址是否广州
     * @param $address
     */
    private function _check_address_in_GuangZhuo($address)
    {
        return strcmp(mb_substr($address, 0, 6), '广东省广州市') === 0;
    }

    private function _check_empty_var($array)
    {
        foreach ($array as $key => $value) {
            if (empty($value))
                return false;
        }
        return true;
    }
}