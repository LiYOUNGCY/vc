<?php

class Transport_model extends CI_Model
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
    public function get_transport_list()
    {
        $query = $this->db->get('transport')->result_array();

        foreach ($query as $key => $value) {
            $query[$key]['range'] = $this->_extends_range($value['range']);
        }

        return $query;
    }

    public function get_transport_by_id($id)
    {
        $query = $this->db->where('id', $id)->get('transport')->row_array();

        return $query;
    }

    public function insert_transport($name, $price, $range)
    {
        $data = array(
            'name' => $name,
            'price' => $price,
            'range' => $range
        );

        $this->db->insert('transport', $data);

        return $this->db->insert_id();
    }

    public function update_transport($id, $name, $price, $range)
    {
        $data = array(
            'name' => $name,
            'price' => $price,
            'range' => $range
        );

        $this->db->where('id', $id)->update('transport', $data);

        return $this->db->affected_rows();
    }

    public function delete_transport($id)
    {
        $this->db->where('id', $id)->delete('transport');

        return $this->db->affected_rows();
    }


    private function _extends_range($range_number)
    {
        $data = array(
            0 => '全国',
            1 => '广州市内',
            2 => '广州市外'
        );

        return $data[$range_number];
    }
}
