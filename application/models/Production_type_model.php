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


}