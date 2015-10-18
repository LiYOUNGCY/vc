<?php


class Frame_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }


    public function get_frame_by_production_id($production_id)
    {
        $query = $this->db->select('frame.name, frame.price, image.image_path as image, frame.thumb_id')
            ->from('frame, production_frame, image')
            ->where('frame.id = production_frame.frame_id')
            ->where('production_frame.production_id', $production_id)
            ->where('image.image_id = frame.image_id')
            ->get()
            ->result_array();

        foreach ($query as $key => $value) {
            $query[$key]['thumb'] = $this->db->select('image.image_path')
                ->from('image')
                ->where('image.image_id', $query[$key]['thumb_id'])
                ->get()
                ->row_array()['image_path'];

            unset($query[$key]['thumb_id']);
        }

        return $query;
    }


    public function get_frame_id_by_production_id($id)
    {
        $query = $this->db->select('production_frame.frame_id')->from('production_frame')->where('production_frame.production_id', $id)->get()->result_array();
        return $query;
    }


    public function get_frame_list()
    {
        $query = $this->db->select('frame.id, frame.name, frame.price')
            ->from('frame')
            ->get()
            ->result_array();

        return $query;
    }


    public function get_frame_by_id()
    {
        $query = $this->db->select('frame.id, frame.name, frame.price, image.image_path as image, frame.thumb_id')
            ->from('frame, image')
            ->where('frame.image_id = image.image_id')
            ->get()
            ->row_array();

        $query['thumb'] = $this->db->select('image.image_path')->from('image')->where('image.image_id', $query['thumb_id'])->get()->row_array()['image_path'];
        unset($query['thumb_id']);

        return $query;
    }


    public function insert_frame($uid, $name, $image_id, $thumb_id, $price)
    {
        $data = array(
            'name' => $name,
            'image_id' => $image_id,
            'thumb_id' => $thumb_id,
            'price' => $price,
            'create_id' => $uid,
            'create_time' => date('Y-m-d H:i:s')
        );
        $this->db->insert('frame', $data);
        return $this->db->insert_id();
    }


    public function update_frame($id, $uid, $name, $image_id, $thumb_id, $price)
    {
        $data = array(
            'name' => $name,
            'image_id' => $image_id,
            'thumb_id' => $thumb_id,
            'price' => $price,
            'modify_id' => $uid,
            'modify_time' => date('Y-m-d H:i:s')
        );
        $this->db->where('id', $id)->update('frame', $data);
        return $this->db->affected_rows() === 1;
    }


    public function delete_frame($id)
    {
        $this->db->where('id', $id)->delete('frame');
        return $this->db->affected_rows() === 1;
    }
}
