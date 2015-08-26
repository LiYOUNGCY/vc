<?php
class Production_type_model extends CI_Model{
	public function __construct()
	{
		parent::__construct();
	}

	public function get_type_list($page = 0,$limit = 10)
	{
		if( ! empty($limit))
		{
			$this->db->limit($limit, $page * $limit);
		}
		$query = $this->db->get('production_type')
						  ->result_array();
		return $query;
	}

	public function get_type_arr()
	{
		$result = $this->get_type_list(0,NULL);
		$arr    = array();
		foreach ($result as $k => $v) {
			$arr[$v['id']] = $v['name'];
		}
		return $arr;
	}	
}