<?php
class Slider_model extends CI_Model{
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * [get_slider_list 获取轮播列表]
	 * @return [type] [description]
	 */
	public function get_slider_list()
	{
		$query = $this->db->get('slider')
						  ->result_array();
		return $query;
	}

	/**
	 * [get_slider_by_id 获取轮播图详情]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function get_slider_by_id($id)
	{
		$query =  $this->db->where('id',$id)
						   ->get('slider')
						   ->row_array();
		return $query;
	}

	/**
	 * [insert_slider 添加轮播图]
	 * @param  [type] $title [标题]
	 * @param  [type] $pic   [图片地址]
	 * @param  [type] $href  [链接地址]
	 * @param  [type] $uid   [用户id]
	 * @return [type]        [description]
	 */
	public function insert_slider($title, $pic, $href, $uid)
	{
		$arr = array(
			'title'      => $title,
			'pic' 	     => $pic,
			'href' 	     => $href,
			'creat_by'   => $uid,
			'creat_time' => date('Y-m-d H:i:s',time())
		);
		$this->db->insert('slider',$arr);
		return $this->db->affected_rows() === 1;
	}

	/**
	 * [update_slider 更新轮播图]
	 * @param  [type] $sid [轮播图id]
	 * @param  [type] $arr [更新键值数组]
	 * @return [type]      [description]
	 */
	public function update_slider($sid,$arr)
	{
		$arr['modify_time'] = date('Y-m-d H:i:s',time());
		$this->db->where('id',$sid)->update('slider',$arr);
		return $this->db->affected_rows() === 1;		
	}

	public function delete_slider($sid)
	{
		$this->db->delete('slider',array('id' => $sid));
		return $this->db->affected_rows() === 1;		
	}
}