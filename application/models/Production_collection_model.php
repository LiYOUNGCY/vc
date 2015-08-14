<?php
class Production_collection_model extends CI_Model{
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * 查看是否收藏该艺术品
	 * @param  uid 用户id   [int]
	 * @param  pid 艺术品id [int]
	 * @return [type]
	 */
	public function check_production_collection($uid, $pid)
	{
		$query = $this->db->where(array('uid' => $uid, 'pid' => $pid)) 
				 		  ->get('production_collection')
				 		  ->row_array();

		return ! empty($query) ? $query : FALSE;
	}

	/**
	 * 添加收藏
	 * @param  pid 艺术品id [int]
	 * @param  uid 用户id   [int]
	 * @return [type]
	 */
	public function insert_collection($pid, $uid)
	{
		$has_collect = $this->check_production_collection($uid, $pid);
		if(empty($has_collect))
		{
			$data  = array(
				'pid'         => $pid,
				'uid' 		  => $uid,
	            'update_time' => date("Y-m-d H:i:s", time())
			);			
			$this->db->insert('production_collection',$data);
		}
		else
		{
			$status = ! $has_collect['status'];
			$this->db->where('id',$has_collect['id'])->update('production_collection',array('status' => $status,'update_time' => date("Y-m-d H:i:s", time())));

		}
		return $this->db->affected_rows() === 1;		
	}		
}