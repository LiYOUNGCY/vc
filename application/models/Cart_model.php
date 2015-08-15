<?php
class Cart_model extends CI_Model{
	public function __construct()
	{
		parent::__construct();
	}	

	public function insert_good($uid, $pid)
	{
		$data = array(
			'uid' 		=> $uid,
			'pid' 		=> $pid,
			'add_time'  => date('Y-m-d H:i:s',time())
		);
		$this->db->insert('cart',$data);
		$id = $this->db->insert_id();
		if($id)
		{	
			return array('id' => $id, 'add_time' => $data['add_time']);
		}
		else
		{
			return FALSE;
		}
	}
	/**
	 * [delete_good 删除物品]
	 * @param  [type] $id  [物品id]
	 * @param  [type] $uid [用户id]
	 * @return [type]      [description]
	 */
	public function delete_good($id,$uid)
	{
		$this->db->delete('cart',array('id' => $id, 'uid' => $uid));
		return $this->db->affected_rows() === 1;
	}

	/**
	 * [get_good_list_by_uid 获取用户的购物车物品]
	 * @param  [type] $uid   [description]
	 * @param  string $order [description]
	 * @return [type]        [description]
	 */
	public function get_good_list_by_uid($uid, $order = 'id DESC')
	{
		$query =  $this->db->where('uid',$uid)
						   ->order_by($order)
						   ->get('cart')
						   ->result_array();
		return $query;
	}
}