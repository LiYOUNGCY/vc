<?php


class Cart_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * [get_good_list_by_uid 获取用户的购物车物品].
     *
     * @param [type] $uid   [description]
     * @param string $order [description]
     *
     * @return [type] [description]
     */
    public function get_good_list_by_user($user_id, $order = 'id DESC')
    {
        $query = $this->db
            ->select('
                    cart.id as id,
                    production.id as production_id,
                    production.name,
                    image.image_path as pic,
                    production_style.name as style,
                    production_medium.name as medium,
                    production.price,
                    production.w,
                    production.h,
                    production.creat_time,
                    frame.name as frame_name,
                    frame.price as frame_price,
                    artist.id as artist_id,
                    artist.name as artist_name
                    ')
            ->from('production, image, cart, frame, artist, production_medium, production_style')
            ->where('production.image_id = image.image_id')
            ->where('cart.production_id = production.id')
            ->where('frame.id = cart.frame_id')
            ->where('artist.id = production.aid')
            ->where('cart.user_id', $user_id)
            ->where('production.style = production_style.id')
            ->where('production.medium = production_medium.id')
            ->get()->result_array();

        return $query;
    }

    /**
     * [insert_goods_to_cart 添加艺术品到购物车].
     *
     * @param [type] $user_id       [description]
     * @param [type] $production_id [description]
     * @param [type] $frame_id      [description]
     * @param int    $amount        [description]
     *
     * @return [type] [description]
     */
    public function insert_goods_to_cart($user_id, $production_id, $frame_id, $amount = 1)
    {
        $data = array(
            'user_id' => $user_id,
            'production_id' => $production_id,
            'frame_id' => $frame_id,
            'amount' => $amount,
            'create_time' => date('Y-m-d H:i:s'),
        );

        $this->db->insert('cart', $data);

        return $this->db->insert_id();
    }

    /**
     * [get_cart_count_by_user 获取购物车上商品的数量].
     *
     * @param [type] $user_id [description]
     *
     * @return [type] [description]
     */
    public function get_cart_count_by_user($user_id)
    {
        $this->db->from('cart')->where('user_id', $user_id);

        return array('count' => $this->db->count_all_results());
    }

    /**
     * [check_production_in_cart 检查艺术品是否在购物车上].
     *
     * @param [type] $user_id       [description]
     * @param [type] $production_id [description]
     *
     * @return [type] [description]
     */
    public function check_production_in_cart($user_id, $production_id)
    {
        $this->db->from('cart')->where('user_id', $user_id)->where('production_id', $production_id);

        return $this->db->count_all_results() > 0;
    }

    /**
     * [remove_goods 从购物车移除商品].
     *
     * @param [type] $user_id       [description]
     * @param [type] $production_id [description]
     *
     * @return [type] [description]
     */
    public function remove_goods($user_id, $production_id)
    {
        $this->db
            ->where('user_id', $user_id)
            ->where('production_id', $production_id)
            ->delete('cart');

        return $this->db->affected_rows() === 1;
    }
}
