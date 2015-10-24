<?php

class Production_price_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 获取所有的价格段.
     *
     * @return mixed
     */
    public function get_price_list()
    {
        $query = $this->db->get('production_price')->result_array();

        return $query;
    }

    public function get_price_by_id($id)
    {
        $query = $this->db->where('id', $id)->get('production_price')->row_array();

        return $query;
    }

    public function insert_price($name, $value)
    {
        $data = array(
            'name' => $name,
            'value' => $value,
        );

        $this->db->insert('production_price', $data);

        return $this->db->insert_id();
    }

    public function update_price($id, $name, $value)
    {
        $data = array(
            'name' => $name,
            'value' => $value,
        );

        $this->db->where('id', $id)->update('production_price', $data);

        return $this->db->affected_rows();
    }

    public function delete_price($id)
    {
        $this->db->where('id', $id)->delete('production_price');

        return $this->db->affected_rows();
    }
}
