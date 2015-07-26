<?php 

class Notification_model extends CI_Model{
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * [get_notification_list 获取用户的消息列表]
	 * @param  [type] $page [页面数]
	 * @param  [type] $uid  [用户id]
	 * @param  [type] $type [消息类型]
	 * @param  [type] $limit[页面显示个数]
	 * @param  [type] $order[排序]
	 * @return [type]       [description]
	 */
	public function get_notification_list($page = 0,$uid,$type,$limit = 10,$order = 'publish_time DESC')
	{
		$query = $this->db->select('notification.*');
		if($type != 0)
		{
			$this->db->where('notification.type',$type);
		}
		$query = $this->db->where('notification.reciver_id',$uid)
						  ->order_by($order)
						  ->limit($limit, $page*$limit)
						  ->get('notification')
		     		      ->result_array();

		return $query;
	}

	/**
	 * [get_notification_group 获取消息组]
	 * @param  [type] $uid [用户id]
	 * @return [type]      [description]
	 */
	public function get_notification_group($uid,$order = 'publish_time DESC')
	{
		$query = $this->db->where('reciver_id',$uid)
						  ->order_by($order)
						  ->get('notification_group')
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
		$result = $this->db->affected_rows() === 1; 
		/**
		 * 日后修改,不规范
		 */
		if($result)
		{
			//查看是否已有消息组
			$check_result = $this->check_has_notification_group($reciver_id,$type);
			if($check_result)
			{
				//更新消息组
				$count = (int)$check_result['count'] + 1;
				$this->update_notification_group($check_result['id'],array('count' => $count,'read_flag' => 0));
			}
			else
			{
				//添加消息组
				$this->insert_notification_group($sender_id,$reciver_id,$type);			
			}
			return $this->db->affected_rows() === 1; 			
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * [check_conversation_notification 查看与某人的私信消息是否存在]
	 * @param  [type] $sender_id  [description]
	 * @param  [type] $reciver_id [description]
	 * @return [type]             [description]
	 */
	public function check_conversation_notification($sender_id,$reciver_id)
	{
		$query = $this->db->where(array('sender_id' => $sender_id,'reciver_id' => $reciver_id,'type' => 1))
						  ->get('notification')
						  ->row_array();
		return $query;
	}

	/**
	 * [update_notification 更新消息]
	 * @param  [type] $nid [消息id]
	 * @param  [type] $arr [键值数组]
	 * @return [type]      [description]
	 */
	public function update_notification($nid,$arr)
	{
		$this->db->where('id',$nid)
				 ->update('notification',$arr);
		return $this->db->affected_rows() === 1;		
	}


	/**
	 * [insert 添加新消息组]
	 * @param  [type] $sender_id  [description]
	 * @param  [type] $reciver_id [description]
	 * @param  [type] $type       [description]
	 * @return [type]             [description]
	 */
	public function insert_notification_group($sender_id,$reciver_id,$type)
	{
		$data = array(
			'sender_id'   => $sender_id,
			'reciver_id'  => $reciver_id,
			'type' 	      => $type,
			'publish_time'=> date('Y-m-d H-m-s')
 		);
 		$this->db->insert('notification_group',$data);
		return $this->db->affected_rows() === 1; 		
	}

	/**
	 * [check_has_notification_group 查看某人的消息组是否存在]
	 * @param  [type] $reciver_id [description]
	 * @param  [type] $type 	  [description]
	 * @return [type]             [description]
	 */
	public function check_has_notification_group($reciver_id,$type)
	{
		$query = $this->db->where(array('reciver_id' => $reciver_id,'type' => $type))
						  ->get('notification_group')
						  ->row_array();
		return $query;
	}	

	/**
	 * [update 更新消息组]
	 * @param  [type] $uid [用户id]
	 * @param  [type] $nid [消息id]
	 * @param  [type] $arr [键值数组]
	 * @return [type]      [description]
	 */
	public function update_notification_group($nid, $arr, $uid = NULL)
	{
		$arr['publish_time'] = date('Y-m-d H-m-s');
		if( ! empty($uid))
		{
			$this->db->where('uid',$uid);
		}
		$this->db->where(array('id' => $nid))
				 ->update('notification_group',$arr);

		return $this->db->affected_rows() === 1;
	}

}