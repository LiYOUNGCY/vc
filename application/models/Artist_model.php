<?php
class Artist_model extends CI_Model{
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * 根据id获取艺术家信息
	 * @param  [type]
	 * @return [type]
	 */
	public function get_artist_by_id($id)
	{
		$query = $this->db->where('id',$id)
				 		  ->get('artist')
				 		  ->row_array();
		return $query;
	}

	/**
	 * [update_artist 更新艺术家信息]
	 * @param  [type] $aid [艺术家id]
	 * @param  [type] $arr [更新键值数组]
	 * @return [type]      [description]
	 */
	public function update_artist($aid,$arr)
	{
		$arr['modify_time'] = array(date("Y-m-d H:i:s", time()),TRUE);
		$this->db->where('id',$aid);
		foreach ($arr as $k => $v) {
			$this->db->set($k,$v[0],$v[1]);
		}
		$this->db->update('artist');
		return $this->db->affected_rows() === 1;
	}

	/**
	 * [get_artist_list 获取艺术家列表]
	 * @param  integer $page  [页数]
	 * @param  integer $limit [页面个数限制]
	 * @param  string  $order [排序]
	 * @return [type]         [description]
	 */
	public function get_artist_list($page = 0, $limit = 6, $order = '')
	{
		$this->db->select('artist.id, artist.name, artist.pic, artist.intro');
		if( ! empty($order))
		{
			$this->db->order_by($order);
		}
		$query = $this->db->limit($limit,$page * $limit)
				 		  ->get('artist')
				 		  ->result_array();
		return $query;
	}

	/**
	 * [insert_artist 添加艺术家]
	 * @param  [type] $uid        [用户id]
	 * @param  [type] $name       [名称]
	 * @param  [type] $intro      [介绍]
	 * @param  [type] $evaluation [评价]
	 * @param  [type] $pic        [头像]
	 * @return [type]             [description]
	 */
	public function insert_artist($uid, $name, $intro, $evaluation, $pic)
	{
		$data = array(
			'name'   	 => $name,
			'intro'  	 => $intro,
			'evaluation' => $evaluation,
			'pic' 		 => $pic,
			'creat_by' 	 => $uid,
			'creat_time' => date("Y-m-d H:i:s", time())
		);
		$this->db->insert('artist',$data);
		return $this->db->insert_id();
	}	

}