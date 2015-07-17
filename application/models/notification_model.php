<?php 

class Notification_model extends CI_Model{
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * [get_notification_by_id 获取用户的消息列表]
	 * @param  [type] $uid  [用户id]
	 * @param  [type] $type [消息类型]
	 * @return [type]       [description]
	 */
	public function get_notification_by_id($uid,$type,$order = 'id DESC')
	{
		$query = $this->db->select('notification.*,user.pic,user.name,user.alias')
						  ->join('user','notification.sender_id = user.id');
		if(!empty($type))
		{
			$this->db->where('notification.type',$type);
		}
		$query = $this->db->where('notification.reciver_id',$uid)
						  ->order_by($order)
						  ->get('notification',10,0)
		     		      ->result_array();

		return $query;
	}

	/**
	 * [update 更新消息]
	 * @param  [type] $uid [用户id]
	 * @param  [type] $nid [消息id]
	 * @param  [type] $arr [键值数组]
	 * @return [type]      [description]
	 */
	public function update($uid,$nid,$arr)
	{
		$this->db->where(array('reciver_id' => $uid, 'id' => $nid))
				 ->update('notification',$arr);

		return $this->db->affected_rows() === 1;
	}

	/**
	 * [delete 删除消息]
	 * @param  [type] $uid [用户id]
	 * @param  [type] $nid [消息id]
	 * @return [type]      [description]
	 */
	public function delete($uid,$nid)
	{
		$this->db->delete('notification',array('reciver_id' => $uid, 'id' => $nid));
		return $this->db->affected_rows() === 1;		
	}

	/**
	 * [insert 添加新消息]
	 * @param  [type] $sender_id  [description]
	 * @param  [type] $reciver_id [description]
	 * @param  [type] $type       [description]
	 * @param  [type] $content    [description]
	 * @return [type]             [description]
	 */
	public function insert($sender_id,$reciver_id,$type,$content)
	{
		$data = array(
			'sender_id'   => $sender_id,
			'reciver_id'  => $reciver_id,
			'type' 	      => $type,
			'content' 	  => $content,
			'publish_time'=> date('Y-m-d H-m-s')
 		);
 		$this->db->insert('notification',$data);
		return $this->db->affected_rows() === 1; 		
	}

}