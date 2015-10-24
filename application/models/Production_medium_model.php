<?php

class Production_medium_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 获取所有的题材.
     *
     * @return mixed
     */
    public function get_medium_list()
    {
        $query = $this->db->get('production_medium')->result_array();

        return $query;
    }

    public function get_medium_by_id($id)
    {
        $query = $this->db->where('id', $id)->get('production_medium')->row_array();

        return $query;
    }

    public function insert_medium($name)
    {
        $data = array(
            'name' => $name,
        );

        $this->db->insert('production_medium', $data);

        return $this->db->insert_id();
    }

    public function update_medium($id, $name)
    {
        $data = array(
            'name' => $name,
        );

        $this->db->where('id', $id)->update('production_medium', $data);

        return $this->db->affected_rows();
    }

    public function delete_medium($id)
    {
        $this->db->where('id', $id)->delete('production_medium');

        return $this->db->affected_rows();
    }
}
