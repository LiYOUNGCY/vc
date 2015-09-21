<?php

class Production_style_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }


    /**
     * 获取所有的题材
     * @return mixed
     */
    public function get_style_list()
    {
        $query = $this->db->get('production_style')->result_array();
        return $query;
    }


    public function insert_style($name)
    {
        $data = array(
            'name'  => $name
        );

        $this->db->insert('production_style', $data);
        return $this->db->insert_id();
    }


    public function update_style($id, $name)
    {
        $data = array(
            'name'  => $name
        );

        $this->db->where('id', $id)->update('production_style', $data);
        return $this->db->affect_rows();
    }



    public function delete_style($id)
    {
        $this->db->where('id', $id)->delete('production_style');
        return $this->db->affect_rows();
    }
}