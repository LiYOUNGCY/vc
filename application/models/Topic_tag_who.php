<?php

class Topic_tag_who_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }


    /**
     * 获取所有的送给谁的专题标签
     * @return mixed
     */
    public function get_topic_tag_who_list()
    {
        $query = $this->db->get('topic_tag_who')->result_array();
        return $query;
    }

    public function get_topic_tag_who_by_id($id) {
        $query = $this->db->where('id', $id)->get('topic_tag_who')->row_array();
        return $query;
    }


    public function insert_topic_tag_who($name)
    {
        $data = array(
            'name'  => $name
        );

        $this->db->insert('topic_tag_who', $data);
        return $this->db->insert_id();
    }


    public function update_topic_tag_who($id, $name)
    {
        $data = array(
            'name'  => $name
        );

        $this->db->where('id', $id)->update('topic_tag_who', $data);
        return $this->db->affected_rows();
    }



    public function delete_topic_tag_who($id)
    {
        $this->db->where('id', $id)->delete('topic_tag_who');
        return $this->db->affected_rows();
    }
}