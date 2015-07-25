<?php

class Feed_model extends CI_Model {
    public function __construct()
    {
        parent::__construct();
    }

    public function insert_feed($uid, $cid, $type, $content)
    {
    	if( is_array($content) ) {
    		$content = json_encode($content);
    	}
        $data = array(
            'uid'       => $uid,
            'cid'       => $cid,
            'type'      => $type,
            'content'   => $content,
            'publish_time'   => date('y-m-d h:i:s',time())
        );

        $this->db->insert('feed', $data);
        return $this->db->affected_rows() === 1 ? $this->db->insert_id() : FALSE;
    }

    public function delete_feed($uid, $cid, $type)
    {
        $data = array(
                'uid'   => $uid,
                'cid'   => $cid,
                'type'  => $type
            );
        $this->db->delete('feed', $data);
        return $this->db->affected_rows() === 1;
    }

    /**
     * [get_feed_list 获取动态列表]
     * @param  integer $page  [页数]
     * @param  [type]  $uids  [关注的用户集合]
     * @param  integer $limit [页面个数限制]
     * @param  string  $order [排序]
     * @return [type]         [description]
     */
    public function get_feed_list($page = 0, $uids, $limit = 0, $order = 'id DESC')
    {
        $query = $this->db->order_by($order)
                          ->limit($limit, $page*$limit)
                          ->where_in('uid',$uids)
                          ->get('feed')
                          ->result_array();

        //echo var_dump($query);
        return $query;
    }
}