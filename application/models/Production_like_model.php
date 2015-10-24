<?php

class Production_like_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_like_list($page = 0, $uid, $limit = 10, $order = 'id DESC')
    {
        $query = $this->db->select('
            production.id,
            production.name,
            production.aid,
            production.price,
            image.thumb_path as pic,
            production.like,
            production_medium.name as medium,
            production.l,
            production.w,
            production.h,
            image.thumb_width as width,
            image.thumb_height as height
            ')
        ->from('production, production_like, production_medium, image')
        ->where('production.image_id = image.image_id')
        ->where('production.medium = production_medium.id')
        ->where('production_like.uid', $uid)
        ->where('production_like.pid = production.id')
        ->where('production_like.status', 1)
        ->limit($limit, $page * $limit)->get()->result_array();

        return $query;
    }

    /**
     * [article_vote 作品点赞或取消].
     *
     * @param [type] $pid [作品id]
     * @param [type] $uid [用户id]
     *
     * @return [type] [TRUE:点赞, FALSE:取消点赞]
     */
    public function insert_like($pid, $uid)
    {
        $query = $this->check_like($pid, $uid);
        //首次点赞
        if (empty($query)) {
            $data = array(
                'pid' => $pid,
                'uid' => $uid,
                'status' => 1,
                'update_time' => date('Y-m-d H:i:s', time()),
            );
            $this->db->insert('production_like', $data);

            return $this->db->affected_rows() === 1;
        } else {
            $status = !$query['status'];
            $this->db->where('id', $query['id'])
                     ->update('production_like', array('status' => $status, 'update_time' => date('Y-m-d H:i:s', time())));

            $result = $this->db->affected_rows() === 1;
            if ($result) {
                return array('status' => $status);
            } else {
                return false;
            }
        }
    }

    public function check_like($pid, $uid)
    {
        $query = $this->db->where(array('uid' => $uid, 'pid' => $pid))
                           ->get('production_like')
                           ->row_array();

        return $query;
    }
}
