<?php 
class Conversation_model extends CI_Model{
	public function __construct()
	{
		parent::__construct();
	}
	/*
	public function get_conversation_list($page = 0, $uid, $limit = 10, $order = "update_time DESC")
	{
		$query = $this->db->where('aid',$uid)
						  ->or_where('bid',$uid)
						  ->order_by($order)
						  ->limit($limit)
						  ->get('conversation')
						  ->result_array();
		return $query;
	}
	*/

	/**
	 * [get_conversation_by_id 根据对话id获取对话信息]
	 * @param  [type] $cid [对话id]
	 * @return [type]      [description]
	 */
	public function get_conversation_by_id($cid)
	{
		$query = $this->db->where('id',$cid)
						  ->get('conversation')
						  ->row_array();
		return $query;
	}

	/**
	 * [get_conversation_by_uid 根据用户id获取对话信息]
	 * @param  [type] $aid [a用户id]
	 * @param  [type] $bid [b用户id]
	 * @return [type]      [description]
	 */
	public function get_conversation_by_uid($aid,$bid)
	{
		$query = $this->db->where(array('aid' => $aid,'bid' => $bid))
						  ->get('conversation')
						  ->row_array();
		return $query;
	}

	/**
	 * [insert_conversation 添加对话]
	 * @param  [type] $aid [a用户id]
	 * @param  [type] $bid [b用户id]
	 * @return [type]      [description]
	 */
	public function insert_conversation($aid, $bid)
	{
		$arr = array(
			'aid' => $aid,
			'bid' => $bid,
			'update_time' => date("Y-m-d H:i:s", time())
		);
		$this->db->insert('conversation',$arr);
		return $this->db->insert_id();
	}

	/**
	 * [update_conversation 更新对话信息]
	 * @param  [type] $cid [对话id]
	 * @param  [type] $arr [对话键值数组]
	 * @return [type]      [description]
	 */
	public function update_conversation($cid,$arr)
	{
		$arr['update_time'] = date("Y-m-d H:i:s", time());
		$this->db->where('id',$cid)->update('conversation',$arr);
		return $this->db->affected_rows() === 1;		
	}
}