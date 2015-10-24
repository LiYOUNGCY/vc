<?php

class Production_categories_model extends CI_Model
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
    public function get_categories_list()
    {
        $query = $this->db->get('production_categories')->result_array();

        return $query;
    }

    public function get_categories_by_id($id)
    {
        $query = $this->db->where('id', $id)->get('production_categories')->row_array();

        return $query;
    }

    public function insert_categories($name)
    {
        $data = array(
            'name' => $name,
        );

        $this->db->insert('production_categories', $data);

        return $this->db->insert_id();
    }

    public function update_categories($id, $name)
    {
        $data = array(
            'name' => $name,
        );

        $this->db->where('id', $id)->update('production_categories', $data);

        return $this->db->affected_rows();
    }

    public function delete_categories($id)
    {
        $this->db->where('id', $id)->delete('production_categories');

        return $this->db->affected_rows();
    }
}
