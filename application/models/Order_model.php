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
        $order_name = 'Artvc - ' . $order_no;
        $time = date("Y-m-d H:i:s");

//        $data = array(
//            //订单号为 当前的时间戳 + 16位的随机字符串
//            'order_no' => $order_no,
//            //订单名称为 Artvc - 订单号
//            'order_name' => 'Artvc - ' . $order_no,
//            'user_id' => $user_id,
//            'contact_id' => $contact_id,
//            'transport_id' => $transport_id,
//            'issue_header' => $issue_header,
//            'create_time' => date("Y-m-d H:i:s")
//        );
//
//        $this->db->insert('order', $data);

        $address_table = $this->db->dbprefix('user_address');
        $transport_table = $this->db->dbprefix('transport');
        $order_table = $this->db->dbprefix('order');

        $sql = "INSERT INTO {$order_table}(order_no, order_name, user_id, contact, phone, address, transport_name, transport_price, create_time, issue_header) SELECT ?, ?, ?, {$address_table}.contact, {$address_table}.phone, {$address_table}.address, {$transport_table}.name, {$transport_table}.price, ?, ? FROM {$address_table}, {$transport_table} WHERE {$address_table}.id = ? AND {$transport_table}.id = ?";

        $this->db->query($sql, array($order_no, $order_name, $user_id, $time, $issue_header, $contact_id, $transport_id));

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
            ->select('order.transport_price')
            ->from('order')
            ->where('order.id', $order_id)
            ->get()
            ->row_array()['transport_price'];

        //计算总价
        $total = $production_total + $transport_total;
        $poundage = Common::alipay_poundage($total);
        $total = $poundage + $total;

        $data = array(
            'total' => $total,
            'transport_price' => $transport_total,
            'poundage' => $poundage
        );

        //更新 order 总价
        $this->db->where('order.id', $order_id)->update('order', $data);
    }

    public function update_orderItem_by_production($user_id, $order_id, $production_id, $frame_id)
    {
        $orderItem_table = $this->db->dbprefix('orderitem');
        $production_table = $this->db->dbprefix('production');
        $frame_table = $this->db->dbprefix('frame');
        $production_frame_table = $this->db->dbprefix('production_frame');


        $sql = "INSERT INTO {$orderItem_table}(order_id, production_id, amount, frame_id, total)
SELECT ?, ?, 1, ?, ({$frame_table}.price + {$production_table}.price)
FROM {$production_table}, {$production_frame_table}, {$frame_table}
WHERE {$production_table}.id = ? AND {$production_table}.id = {$production_frame_table}.production_id AND {$production_frame_table}.frame_id = {$frame_table}.id AND {$frame_table}.id = ?";

        $this->db->query($sql, array($order_id, $production_id, $frame_id, $production_id, $frame_id));

        //查询 艺术品 的总价
        $production_total = (int)$this->db
            ->select_sum('orderitem.total')
            ->where('orderitem.order_id', $order_id)
            ->get('orderitem')
            ->row_array()['total'];

        //查询 运费
        $transport_total = (int)$this->db
            ->select('order.transport_price')
            ->from('order')
            ->where('order.id', $order_id)
            ->get()
            ->row_array()['transport_price'];

        //计算总价
        $total = $production_total + $transport_total;
        $poundage = Common::alipay_poundage($total);
        $total = $poundage + $total;

        $data = array(
            'total' => $total,
            'transport_price' => $transport_total,
            'poundage' => $poundage
        );

        //更新 order 总价
        $this->db->where('order.id', $order_id)->update('order', $data);
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

    /**
     * 支付成功
     * @param $order_no
     */
    public function complete_order($order_no)
    {
        $query = $this->db->select('production.id')
            ->from('production, order, orderitem')
            ->where('order.order_no', $order_no)
            ->where('order.id = orderitem.order_id')
            ->where('orderitem.production_id = production.id')
            ->get()
            ->result_array();

        foreach ($query as $key => $value) {
            $data = array(
                'status' => 1
            );
            $this->db->where('id', $value['id'])->update('production', $data);
        }

//        $data = array(
//            'status' => 1
//        );
//        $this->db
//            ->where('order.order_no', $order_no)
//            ->where('order.id = orderitem.id')
//            ->where('orderitem.production_id = production.id')
//            ->from('order, orderitem')
//            ->update('production', $data);

        $data = array(
            'state' => 2
        );
        $this->db->where('order.order_no', $order_no)->update('order', $data);
    }

    public function get_order_list($state = '')
    {
        $query = $this->db
            ->select('order.id, order.order_name, user.name as user_name, order.transport_name, order.state, order.total, order.create_time')
            ->from('order, user')
            ->where('order.user_id = user.id');

        if (!empty($state)) {
            $query = $query->where('state', $state);
        }

        $query = $query->get()->result_array();

        foreach ($query as $key => $value) {
            $query[$key]['state'] = $this->_extends_state($value['state']);
        }

        return $query;
    }

    private function _extends_state($number)
    {
        $ret = array(
            1 => '未支付',
            2 => '待发货',
            3 => '已发货',
            4 => '已收货'
        );

        return $ret[$number];
    }

    public function get_order_by_id($order_id)
    {
        $query = $this->db
            ->select('order.id,order.order_name, order.order_no, user.name as user_name, order.transport_name, order.transport_price, order.state, order.create_time, order.issue_header, order.contact, order.phone, order.address, order.poundage, order.transport_price, order.total')
            ->from('order, user')
            ->where('order.user_id = user.id')
            ->where('order.id', $order_id)
            ->get()
            ->row_array();

        $query['state_name'] = $this->_extends_state($query['state']);

        return $query;
    }

    public function get_orderitem_by_order_id($order_id)
    {
        $query = $this->db
            ->select('
                    orderitem.id as id,
                    production.id as production_id,
                    production.name,
                    image.image_path as pic,
                    production_style.name as style,
                    production_medium.name as medium,
                    production.price,
                    production.w,
                    production.h,
                    production.status,
                    production.creat_time,
                    frame.name as frame_name,
                    frame.price as frame_price,
                    artist.id as artist_id,
                    artist.name as artist_name,
                    orderitem.total as sum_price
                    ')
            ->from('production, image, orderitem, frame, artist, production_medium, production_style')
            ->where('orderitem.order_id', $order_id)
            ->where('production.image_id = image.image_id')
            ->where('orderitem.production_id = production.id')
            ->where('frame.id = orderitem.frame_id')
            ->where('artist.id = production.aid')
            ->where('production.style = production_style.id')
            ->where('production.medium = production_medium.id')
            ->get()->result_array();


        return $query;
    }

    public function change_state($order_id, $state)
    {
        $data = array(
            'state' => $state
        );

        $this->db->where('id', $order_id)->update('order', $data);
        return $this->db->affected_rows() === 1;
    }

    public function get_order_information_by_id($user_id)
    {
        $query = $this->db
            ->select('order.id, order.total, order.transport_name, order.address, order.state, order.create_time, order.phone, order.contact, order.poundage, order.transport_price')
            ->from('order')
            ->where('order.state != 1')
            ->where('order.user_id', $user_id)
            ->get()
            ->result_array();

        if(empty($query)) {
            return false;
        }

        foreach($query as $key => $value) {
            $query[$key]['production'] = $this->db
                ->select('orderitem.total, production.id as production_id, production.name as production_name, image.image_path as pic, production.price as production_price, frame.price as frame_price, frame.name as frame_name, orderitem.total')
                ->from('orderitem, production, frame, image')
                ->where('orderitem.order_id', $value['id'])
                ->where('production.image_id = image.image_id')
                ->where('orderitem.production_id = production.id')
                ->where('orderitem.frame_id = frame.id')
                ->get()
                ->result_array();
        }

        return $query;
    }
}
