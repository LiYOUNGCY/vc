<?php


class Cart_service extends MY_Service
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('cart_model');
        $this->load->model('frame_model');
        $this->load->model('production_model');
    }

    /**
     * [insert_goods_to_cart 添加艺术品到购物车].
     *
     * @param [type] $user_id       [description]
     * @param [type] $production_id [description]
     * @param [type] $frame_id      [description]
     *
     * @return [type] [description]
     */
    public function insert_goods_to_cart($user_id, $production_id, $frame_id)
    {
        //检查 艺术品 是否 存在
        $state = $this->production_model->exist_production($production_id);

        if ($state != true) {
            $this->message->error('没有该艺术品');
        }

        //检查 艺术品 是否有推荐该 裱
        $state = $this->frame_model->check_frame_by_production_id($frame_id, $production_id);

        if ($state != true) {
            $this->message->error('该艺术品没有该裱');
        }

        //检查 购物车 是否有该 艺术品
        $state = $this->cart_model->check_production_in_cart($user_id, $production_id);

        if ($state == true) {
            $this->message->error('您的购物车已经有该艺术品');
        }

        //把 艺术品 放入购物车
        $result = $this->cart_model->insert_goods_to_cart($user_id, $production_id, $frame_id);
    }

    /**
     * [remove_goods 从购物车移除艺术品].
     *
     * @param [type] $user_id       [description]
     * @param [type] $production_id [description]
     *
     * @return [type] [description]
     */
    public function remove_goods($user_id, $production_id)
    {
        return $this->cart_model->remove_goods($user_id, $production_id);
    }

    /**
     * [get_good_list 获取购物车物品列表].
     *
     * @param [type] $uid   [用户id]
     * @param int    $page  [页数]
     * @param int    $limit [页面个数限制]
     *
     * @return [type] [description]
     */
    public function get_good_list($uid)
    {
        $goods = $this->cart_model->get_good_list_by_user($uid);

        return $goods;
    }

    /**
     * [get_cart_count_by_user 获取购物车上商品的数量].
     *
     * @param [type] $uid [description]
     *
     * @return [type] [description]
     */
    public function get_cart_count_by_user($uid)
    {
        return $this->cart_model->get_cart_count_by_user($uid);
    }

    public function check_goods_sell_out($user_id)
    {
        return $this->cart_model->check_goods_sell_out($user_id);
    }

    /**
     * 清空购物车
     * @param $user_id
     * @return mixed
     */
    public function empty_cart($user_id)
    {
        return $this->cart_model->empty_cart($user_id);
    }
}
