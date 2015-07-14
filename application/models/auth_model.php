<?php
class auth_model extends CI_Model{
	
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * [get_user_auth 获取所有权限集合]
	 * @return [type] [description]
	 */
	public function get_user_auth()
	{
		$query = $this->db->get('user_auth')
				 		  ->result_array();
		return $query;
	}
}