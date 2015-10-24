<?php

class Customer_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function insert_message($data)
    {
        $this->db->insert('customer', $data);

        return $this->db->insert_id();
    }

    public function get_history_by_user($uid)
    {
        $query = $this
            ->db
            ->select('sender, uid, cid, msg, time')
            ->where('uid', $uid)
            ->get('customer')
            ->result_array();

        return $query;
    }

    public function get_customer_id()
    {
        $query = $this
            ->db
            ->select('id')
            ->where('role', 90)
            ->get('user')
            ->result_array();

        return $query;
    }
}
