<?php


class Image_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }



    /**
     * [insert_artist_image 插入艺术家照片]
     * @param  [type] $image_path   [description]
     * @param  [type] $image_width  [description]
     * @param  [type] $image_height [description]
     * @return [type]               [description]
     */
    public function insert_artist_image($image_path, $image_width, $image_height)
    {
        $data = array(
                'image_path' => $image_path,
                'image_width' => $image_width,
                'image_height' => $image_height,
                'hasthumb'  => 0
            );

        $this->db->insert('image', $data);
        return $this->db->insert_id();
    }


    public function insert_production_image()
    {

    }
}
