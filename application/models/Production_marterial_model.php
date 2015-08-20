<?php
class Production_marterial_model extends CI_Model{
	public function __construct()
	{
		parent::__construct();
	}

	public function get_marterial_list($page = 0,$limit = NULL)
	{
		if( ! empty($limit))
		{
			$this->db->limit($limit, $page * $limit);
		}
		$query = $this->db->get('production_marterial')
						  ->result_array();
		return $query;
	}
}