<?php 
class Community_answer_model extends CI_Model{
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * [get_answer_by_pid 根据帖子id获取评论]
	 * @param  [type] $pid [description]
	 * @return [type]      [description]
	 */
	public function get_answer_by_pid($pid)
	{
		$query = $this->db->where('pid',$pid)
						  ->get('community_answer')
						  ->result_array();
		return $query;
	}

	/**
	 * [insert_answer 添加回复]
	 * @param  [type] $pid     [帖子id]
	 * @param  [type] $uid     [用户id]
	 * @param  [type] $content [回复内容]
	 * @return [type]          [description]
	 */
	public function insert_answer($pid, $uid, $content)
	{
		$arr = array(
			'pid'  	  	  => $pid,
			'uid' 	  	  => $uid,
			'content' 	  => $content,
			'answer_time' => date("Y-m-d H:i:s", time())
		);
		$this->db->insert('community_answer',$arr);
  		return $this->db->affected_rows() === 1;		
	}
}