<?php defined('BASEPATH') OR exit('No direct script access allowed');


class User_follow_model extends CI_Model{

	public function __construct()
	{
		parent::__construct();
	}	

	/**
	 * [get_user_follow 获取用户联系人列表(关注或粉丝)]
	 * @param  integer $page  [页数]
	 * @param  [type]  $uid   [用户id]
	 * @param  integer $type  [类型(0关注 1粉丝)]
	 * @param  integer $limit [页面个数限制]
	 * @param  string  $order [排序]
	 * @return [type]         [description]
	 */
    public function get_user_follow($page = 0, $uid, $type = 0, $limit = 10, $order = 'update_time DESC')
    {
    	if($type == 0)
    	{
    		$this->db->select('follow as uid,status')->where(array('uid' => $uid,'status' => 1));    		
    	}
    	else
    	{
    		$this->db->select('uid,status')->where(array('follow' => $uid,'status' => 1));    
    	}
		if( ! empty($limit))
		{
			$this->db->order_by($order)->limit($limit, $page*$limit);
		}
    	return $this->db->get('user_follow')->result_array();
    }

    /**
     * [insert_follow 添加关注]
     * @param  [type] $myid [关注者的id]
     * @param  [type] $uid  [被关注者id]
     * @return [type]       [description]
     */
    public function insert_follow($myid, $uid)
    {	
    	$arr  = array(
    		'uid' 		  => $myid, 
    		'follow' 	  => $uid,
    		'status' 	  => 1,
    		'update_time' => date('Y-m-d H-m-s',time())
    		);
    	$this->db->insert('user_follow',$arr);
  		return $this->db->affected_rows() === 1;
    }

    /**
     * [update_follow 更新关注关系]
     * @param  [type] $id [关注记录的id]
     * @return [type]       [description]
     */
    public function update_follow($id, $arr)
    {
    	$arr['update_time'] = date('Y-m-d H-m-s',time());

    	$this->db->where('id',$id)->update('user_follow',$arr);
  		return $this->db->affected_rows() === 1;
    }

    /**
     * [check_follow 查看对某人的关注状态]
     * @param  [type] $myid [关注者的id]
     * @param  [type] $uid  [被关注者id]
     * @return [type]       [description]
     */
    public function check_follow($myid,$uid)
    {
    	$query = $this->db->select('id,status')
		    			  ->where(array('uid' => $myid, 'follow' => $uid))
		    			  ->get('user_follow')
		    			  ->row_array();
		return ! empty($query) ? $query : FALSE;

    }
}