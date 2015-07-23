<?php 
class Community_post_model extends CI_Model{
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * [get_post_list 根据圈子id获取帖子列表]
	 * @param  integer $page  [页数]
	 * @param  [type]  $cid   [圈子id]
	 * @param  integer $limit [页面个数限制]
	 * @param  string  $order [排序]
	 * @return [type]         [description]
	 */
	public function get_post_list($page =0, $cid, $limit = 20, $order = 'id DESC')
	{
		$query = $this->db->where('cid',$cid)
						  ->order_by($order)
						  ->limit($limit, $page*$limit)
						  ->get('community_post')
						  ->result_array();
		return $query;
	}

	/**
	 * [get_post_by_id 根据帖子id获取帖子详情]
	 * @param  [type] $pid [帖子id]
	 * @return [type]      [description]
	 */
	public function get_post_by_id($pid)
	{
		$query = $this->db->where('id',$pid)
						  ->get('community_post')
						  ->row_array();
		return $query;
	}

	/**
	 * [insert_post 添加帖子]
	 * @param  [type] $cid     [圈子id]
	 * @param  [type] $uid     [发布者id]
	 * @param  [type] $title   [标题]
	 * @param  [type] $content [内容]
	 * @return [type]          [description]
	 */
	public function insert_post($cid, $uid, $title, $content)
	{
		$arr = array(
			'cid' 	  	   => $cid,
			'uid' 	   	   => $uid,
			'title'   	   => $title,
			'content' 	   => $content,
			'publish_time' => date("Y-m-d H:i:s", time()),
			'last_active'  => date("Y-m-d H:i:s", time())
		);
		$this->db->insert('community_post',$arr);
  		return $this->db->affected_rows() === 1;		
	}
}