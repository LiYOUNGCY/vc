<?php


class Image_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 插入不带缩略图的图片.
     *
     * @param $image_path
     * @param $image_width
     * @param $image_height
     *
     * @return mixed
     */
    public function insert_image_without_thumb(
        $image_path,
        $image_width,
        $image_height)
    {
        $data = array(
            'image_path' => $image_path,
            'image_width' => $image_width,
            'image_height' => $image_height,
            'hasthumb' => 0,
        );

        $this->db->insert('image', $data);

        return $this->db->insert_id();
    }

    /**
     * 插入带缩略图的图片.
     *
     * @param $image_path
     * @param $image_width
     * @param $image_height
     * @param $thumb_path
     * @param $thumb_width
     * @param $thumb_height
     *
     * @return mixed
     */
    public function insert_image_with_thumb(
        $image_path,
        $image_width,
        $image_height,
        $thumb_path,
        $thumb_width,
        $thumb_height)
    {
        $data = array(
            'image_path' => $image_path,
            'image_width' => $image_width,
            'image_height' => $image_height,
            'hasthumb' => 1,
            'thumb_path' => $thumb_path,
            'thumb_width' => $thumb_width,
            'thumb_height' => $thumb_height,
        );

        $this->db->insert('image', $data);

        return $this->db->insert_id();
    }
}
