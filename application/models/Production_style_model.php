<?php

class Production_style_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }


    /**
     * 获取所有的风格
     * @return mixed
     */
    public function get_style_list()
    {
        $query = $this->db->get('production_style')->result_array();
        return $query;
    }

    public function get_style_by_id($id)
    {
        $query = $this->db->where('id', $id)->get('production_style')->row_array();
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
        return $this->db->affected_rows();
    }



    public function delete_style($id)
    {
        $this->db->where('id', $id)->delete('production_style');
        return $this->db->affected_rows();
    }
}