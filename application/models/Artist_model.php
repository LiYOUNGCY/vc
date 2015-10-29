<?php

class Artist_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_artist_base_id($id, $base = array('id', 'pic', 'name'))
    {
        $query = $this->db->select('artist.id, artist.name, image.image_path as pic')->from('artist')
            ->from('image')->where('artist.image_id = image.image_id')->get()->row_array();

        return $query;
    }

    /**
     * 根据id获取艺术家信息.
     *
     * @param  [type]
     *
     * @return [type]
     */
    public function get_artist_by_id($id)
    {
        $query = $this->db->select('artist.id, artist.name, image.image_id, image.image_path as pic, artist.intro, artist.evaluation')
            ->from('artist')
            ->where('artist.id', $id)
            ->join('image', 'artist.image_id = image.image_id')
            ->get()
            ->row_array();

        return $query;
    }

    /**
     * [get_artist_list 获取艺术家列表].
     *
     * @param int    $page  [页数]
     * @param int    $limit [页面个数限制]
     * @param string $order [排序]
     *
     * @return [type] [description]
     */
    public function get_artist_list($page = 0, $limit = 6, $order = '')
    {
        $query = $this->db->select('artist.id, artist.name, image.image_path as pic, artist.intro')
            ->from('artist')
            ->where('artist.publish_status', 1)
            ->join('image', 'artist.image_id = image.image_id')
            ->limit($limit, $page * $limit)->get()->result_array();

        return $query;
    }

    /**
     * [insert_artist 添加艺术家].
     *
     * @param [type] $uid        [用户id]
     * @param [type] $name       [名称]
     * @param [type] $intro      [介绍]
     * @param [type] $evaluation [评价]
     * @param [type] $pic        [头像]
     *
     * @return [type] [description]
     */
    public function insert_artist($uid, $name, $image_id, $intro, $evaluation)
    {
        $data = array(
            'name' => $name,
            'intro' => $intro,
            'evaluation' => $evaluation,
            'image_id' => $image_id,
            'creat_by' => $uid,
            'creat_time' => date('Y-m-d H:i:s'),
        );
        $this->db->insert('artist', $data);

        return $this->db->insert_id();
    }

    /**
     * [update_artist 更新艺术家信息].
     *
     * @param [type] $aid        [description]
     * @param [type] $uid        [description]
     * @param [type] $name       [description]
     * @param [type] $image_id   [description]
     * @param [type] $intro      [description]
     * @param [type] $evaluation [description]
     *
     * @return [type] [description]
     */
    public function update_artist($aid, $uid, $name, $image_id, $intro, $evaluation)
    {
        $data = array(
            'name' => $name,
            'intro' => $intro,
            'evaluation' => $evaluation,
            'image_id' => $image_id,
            'modify_by' => $uid,
            'modify_time' => date('Y-m-d H:i:s'),
        );
        $this->db->where('id', $aid)->update('artist', $data);

        return $this->db->affected_rows();
    }

    public function update_artist_production_count($id)
    {
        $table_name = $this->db->protect_identifiers('artist', true);
        $this->db->query("UPDATE {$table_name} SET {$table_name}.`production` = {$table_name}.`production` + 1 WHERE {$table_name}.id = {$id}");
    }

    /**
     * 根据关键字搜索艺术家.
     *
     * @param $keyword
     *
     * @return mixed
     */
    public function get_artist_by_keyword($keyword)
    {
        $query = $this->db
            ->select('
					artist.id,
					artist.name,
					image.image_path as pic,
					artist.intro,
					artist.creat_time
					')
            ->from('artist, image')
            ->where('image.image_id = artist.image_id')
            ->where('publish_status', '1')
            ->like('artist.name', $keyword)
            ->get()
            ->result_array();

        return $query;
    }

    public function admin_get_artist_list($page = 0, $limit = 10, $order = 'id DESC')
    {
        $query = $this->db->order_by($order)->limit($limit, $page * $limit)->get('artist')->result_array();

        return $query;
    }

    public function get_artist_count()
    {
        return $this->db->count_all('artist');
    }

    public function delete_artist($id)
    {
        $this->db->where('id', $id)->delete('artist');

        return $this->db->affected_rows() === 1;
    }

    public function publish($id)
    {
        $data = array(
            'publish_status' => 1,
        );
        $this->db->where('id', $id)->update('artist', $data);

        return $this->db->affected_rows() === 1;
    }

    public function cancel_publish($id)
    {
        $data = array(
            'publish_status' => 0,
        );
        $this->db->where('id', $id)->update('artist', $data);

        return $this->db->affected_rows() === 1;
    }
}
