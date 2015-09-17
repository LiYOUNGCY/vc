<?php

/**
 * Created by PhpStorm.
 * User: Rache
 * Date: 2015/7/15
 * Time: 21:56
 */
class Customer_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function insert_message($data) {

        $this->db->insert('customer', $data);
        return $this->db->insert_id();
    }
}