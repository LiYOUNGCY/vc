<?php 
class Community_model extends CI_Model{
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * [get_community_by_id 根据圈子id获取圈子详情]
	 * @param  [type] $cid [圈子id]
	 * @return [type]      [description]
	 */
	public function get_community_by_id($cid)
	{	
		$query = $this->db->where('id',$cid)
				 		  ->get('community')
				 		  ->row_array();
		return $query;
	}	

	/**
	 * [get_community_by_uid 根据用户id获取圈子详情]
	 * @param  [type] $uid [用户id]
	 * @return [type]      [description]
	 */
	public function get_community_by_uid($uid)
	{
		$query = $this->db->where('uid',$uid)
				 		  ->get('community')
				 		  ->row_array();
		return $query;
	}

	/**
	 * [insert_community 添加圈子]
	 * @param  [type] $name [圈子名称]
	 * @param  [type] $intro[圈子介绍] 
	 * @param  [type] $uid  [创建者id]
	 * @return [type]       [description]
	 */
	public function insert_community($name, $intro, $uid)
	{
		$arr = array(
			'name' 		 => $name,
			'intro' 	 => $intro,
			'uid'  		 => $uid,
			'creat_time' => date("Y-m-d H:i:s", time())
 		);
 		$this->db->insert('community',$arr);
  		return $this->db->affected_rows() === 1;
	}
}