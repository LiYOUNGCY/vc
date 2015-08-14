<?php 
class Production_model extends CI_Model{

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * 获取作品列表
	 * @param  page 页数 		  integer
	 * @param  meid 我的id   	  [int]
	 * @param  uid  艺术家id 	  [int]
	 * @param  limit页面个数限制  integer
	 * @param  order 排序  		  string
	 * @return [type]
	 */
	public function get_production_list($page = 0, $meid = NULL, $uid = NULL, $limit = 6, $order = 'id DESC')
	{
		$query = $this->db->select('production.id, production.aid, production.name, production.pic, production.price, production.status, production.collection');
		if(is_numeric($meid))
		{
			$query->select('production_collection.status as collect_status');
			$query->join('production_collection','production.id = production_collection.pid','left');
		}
		if( ! empty($uid))
		{			
			$query->where('uid',$uid);
		}

        $query =$query->order_by($order)->limit($limit, $page*$limit)->get('production')->result_array();
        return $query;		
	}
	
	/**
	 * 根据id获取艺术品详情
	 * @param  [type]
	 * @return [type]
	 */
 	public function get_production_by_id($id)
 	{
 		$query = $this->db->where('id',$id)
 				 ->get('production')
 				 ->row_array();
 		return $query;
	}

	/**
	 * [insert_production 添加艺术品]
	 * @param  [type] $name  [名称]
	 * @param  [type] $uid   [用户id]
	 * @param  [type] $aid   [艺术家id]
	 * @param  [type] $price [价格]
	 * @param  [type] $pic   [图片]
	 * @return [type]        [description]
	 */
	public function insert_production($name, $uid, $aid, $price, $pic)
	{
		$data = array(
			'name' 		   => $name,
			'aid'  		   => $aid,
			'price'		   => $price,
			'pic'  		   => $pic,
			'publish_time' => date("Y-m-d H:i:s", time()),
			'creat_by'     => $uid
 		);
		$this->db->insert('production',$data);
		return $this->db->insert_id();
	}

	/**
	 * [update_production 更新]
	 * @param  [type] $pid [description]
	 * @param  [type] $arr [description]
	 * @return [type]      [description]
	 */
	public function update_production($pid, $arr)
	{
		$arr['modify_time'] = date("Y-m-d H:i:s", time());
		$this->db->where('id',$pid)->update('production',$arr);
		return $this->db->affected_rows() === 1;		
	}

} 