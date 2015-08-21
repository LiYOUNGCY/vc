<?php
class Conversation_custom_model extends CI_Model{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function get_conversation_custom_list()
	{
		$query = $this->db->get('conversation_custom')
						  ->result_array();
		return $query;
	}
}