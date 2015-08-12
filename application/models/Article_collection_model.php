<?php
class Article_collection_model extends CI_Model{

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * 查看用户是否收藏文章
	 * @param  uid 用户id[int]
	 * @param  aid 文章id[int]
	 * @return [type]
	 */
	public function check_article_collection($uid, $aid)
	{
		$query = $this->db->where(array('uid' => $uid, 'aid' => $aid, 'status' => 1)) 
				 		  ->get('article_collection')
				 		  ->row_array();

		return ! empty($query) ? $query : FALSE;
	}	


	/**
	 * 添加收藏
	 * @param  aid 文章id [int]
	 * @param  uid 用户id [int]
	 * @return [type]
	 */
	public function insert_collection($aid, $uid)
	{
		$has_collect = $this->check_article_collection($uid, $aid);
		if( ! empty($has_collect))
		{
			$data  = array(
				'aid'         => $aid,
				'uid' 		  => $uid,
	            'update_time' => date("Y-m-d H:i:s", time())
			);			
			$this->db->insert('article_collection',$data);
		}
		else
		{
			$status = ! $has_collect['status'];
			$this->db->where('id',$has_collect['id'])->update('article_collection',array('status' => $status,'update_time' => date("Y-m-d H:i:s", time())));

		}
		return $this->db->affected_rows() === 1;		
	}	
}