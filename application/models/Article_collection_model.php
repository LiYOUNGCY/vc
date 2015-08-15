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
		$query = $this->db->where(array('uid' => $uid, 'aid' => $aid)) 
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
		if(empty($has_collect))
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

	/**
	 * [get_collection_list 获取收藏列表]
	 * @param  integer $page  [页数]
	 * @param  [type]  $uid   [用户id]
	 * @param  integer $limit [页面个数限制]
	 * @param  string  $order [排序]
	 * @return [type]         [description]
	 */
	public function get_collection_list($page  = 0, $uid, $limit = 10, $order = 'id DESC')
	{
		$query = $this->db->where(array('uid' => $uid, 'status' => 1))
						  ->order_by($order)
						  ->limit($limit, $page * $limit)
						  ->get('article_collection')
						  ->result_array();
		return $query;
	}
}