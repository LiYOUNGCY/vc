<?php

class Order_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 创建新订单
     * @param $user_id
     * @param $contact_id
     * @param $transport_id
     * @param $issue_header
     * @return mixed
     */
    public function create_order($user_id, $contact_id, $transport_id, $issue_header)
    {
        $factory = new RandomLib\Factory;
        $generator = $factory->getGenerator(new SecurityLib\Strength(SecurityLib\Strength::LOW));
        $order_no = md5(time() . $generator->generateString(16));

        $data = array(
            //订单号为 当前的时间戳 + 16位的随机字符串
            'order_no' => $order_no,
            //订单名称为 Artvc - 订单号
            'order_name' => 'Artvc - ' . $order_no,
            'user_id' => $user_id,
            'contact_id' => $contact_id,
            'transport_id' => $transport_id,
            'issue_header' => $issue_header,
            'create_time' => date("Y-m-d H:i:s")
        );

        $this->db->insert('order', $data);
        return $this->db->insert_id();
    }

    /**
     * 取出购物车的所有艺术品添加到订单并更新总价
     * 总价 = 艺术品（裸艺术品 + 裱） + 运费 + 手续费
     * @param $user_id
     * @param $order_id
     */
    public function update_orderItem_by_cart($user_id, $order_id)
    {
        $orderItem_table = $this->db->dbprefix('orderitem');
        $cart_table = $this->db->dbprefix('cart');

        $sql = "INSERT INTO {$orderItem_table}(order_id, production_id, amount, frame_id, total) SELECT {$order_id}, {$cart_table}.production_id, 1, {$cart_table}.frame_id, {$cart_table}.price FROM {$cart_table} WHERE {$cart_table}.user_id = {$user_id}";

        $this->db->query($sql);


        //查询 艺术品 的总价
        $production_total = (int)$this->db
            ->select_sum('orderitem.total')
            ->where('orderitem.order_id', $order_id)
            ->get('orderitem')
            ->row_array()['total'];

        //查询 运费
        $transport_total = (int)$this->db
            ->select('transport.price')
            ->from('transport, order')
            ->where('order.transport_id = transport.id')
            ->where('order.id', $order_id)
            ->get()
            ->row_array()['price'];

        //计算总价
        $total = $production_total + $transport_total;
        $total = Common::alipay_poundage($total) + $total;

        //更新 order 总价
        $this->db->where('order.id', $order_id)->update('order', array('total' => $total));
    }

    /**
     * 获取个人的订单的简要信息
     * @param $user_id
     * @param $order_id
     * @return mixed
     */
    public function get_order_message($user_id, $order_id)
    {
        $query = $this->db
            ->select('order.order_no, order.order_name, order.total')
            ->from('order')
            ->where('order.id', $order_id)
            ->where('order.user_id', $user_id)
            ->get()
            ->row_array();

        return $query;
    }
}